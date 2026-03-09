import { useState, useEffect } from "react";
import { useAuth } from "../hooks/useAuth";
import { progressAPI } from "../services/api";
import ProgressBar from "../components/ProgressBar";
import Card from "../components/Card";
import ProgressChart from "../components/ProgressChart";

export default function Progress() {
  const { user } = useAuth();

  const [progress, setProgress] = useState({
    completedLessons: 0,
    totalLessons: 0,
    currentStreak: 0,
    totalPoints: 0
  });

  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchProgress = async () => {
      try {
        const response = await progressAPI.getByUser();
        const data = response.data;
        setProgress({
          completedLessons: data.completed_lessons ?? 0,
          totalLessons:     data.total_lessons     ?? 0,
          currentStreak:    data.current_streak    ?? 0,
          totalPoints:      data.total_points      ?? 0,
        });
      } catch (err) {
        console.error("Progress fetch error:", err);
      } finally {
        setLoading(false);
      }
    };

    fetchProgress();
  }, []);

  const completionRate = progress.totalLessons > 0
    ? (progress.completedLessons / progress.totalLessons) * 100
    : 0;

  if (loading) return <div className="container"><p>Loading...</p></div>;

  return (
    <div className="container">
      <h1>My Progress</h1>
      <p>Track your learning journey, {user?.name || "Student"}!</p>

      <div style={{ marginTop: 20 }}>
        <h3>Overall Progress</h3>
        <ProgressBar
          progress={completionRate}
          showLabel
          label={`${progress.completedLessons} of ${progress.totalLessons} lessons completed`}
          height={20}
        />
      </div>

      <ProgressChart />

      <div style={{
        display: "grid",
        gridTemplateColumns: "repeat(auto-fit, minmax(200px, 1fr))",
        gap: 16,
        marginTop: 20
      }}>
        <Card title="Lessons Completed" subtitle={`${progress.completedLessons} / ${progress.totalLessons}`} />
        <Card title="Current Streak"    subtitle={`${progress.currentStreak} days 🔥`} />
        <Card title="Total Points"      subtitle={`${progress.totalPoints} ⭐`} />
        <Card title="Completion Rate"   subtitle={`${Math.round(completionRate)}%`} />
      </div>

      {progress.completedLessons === 0 && (
        <div style={{ marginTop: 20, padding: 16, backgroundColor: "#f0f8ff", borderRadius: 8, textAlign: "center" }}>
          <p>🚀 Start learning to track your progress!</p>
        </div>
      )}
    </div>
  );
}