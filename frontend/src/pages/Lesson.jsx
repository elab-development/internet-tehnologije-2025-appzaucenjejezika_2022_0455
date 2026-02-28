import { useState, useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import Button from "../components/Button";
import Modal from "../components/Modal";
import AudioPlayer from "../components/AudioPlayer";
import ProgressBar from "../components/ProgressBar";
import { tasksAPI, progressAPI } from "../services/api";

export default function Lesson() {
  const { lessonId } = useParams();
  const navigate = useNavigate();

  const [tasks, setTasks] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");
  
  const [currentTaskIndex, setCurrentTaskIndex] = useState(0);
  const [answer, setAnswer] = useState("");
  const [showModal, setShowModal] = useState(false);
  const [isCorrect, setIsCorrect] = useState(false);
  const [score, setScore] = useState(0);

  useEffect(() => {
    fetchTasks();
  }, [lessonId]);

  const fetchTasks = async () => {
    try {
      setLoading(true);
      setError("");
      setCurrentTaskIndex(0);
      setAnswer("");
      setShowModal(false);
      setIsCorrect(false);
      setScore(0);

      const response = await tasksAPI.getByLesson(lessonId);
      setTasks(response.data?.data ?? response.data);
    } catch (err) {
      console.error("Failed to load tasks:", err);
      setError("Failed to load tasks. Please try again.");
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <div className="container">
        <h1>Loading lesson...</h1>
      </div>
    );
  }

  if (error) {
    return (
      <div className="container">
        <h1>Error</h1>
        <p style={{ color: 'red' }}>{error}</p>
        <Button onClick={fetchTasks}>Try Again</Button>
      </div>
    );
  }

  if (tasks.length === 0) {
    return (
      <div className="container">
        <h1>No Tasks Available</h1>
        <p>This lesson doesn't have any tasks yet.</p>
        <Button onClick={() => navigate(-1)}>Go Back</Button>
      </div>
    );
  }

  const currentTask = tasks[currentTaskIndex];
  const progress = ((currentTaskIndex + 1) / tasks.length) * 100;

  const checkAnswer = () => {
    const userAnswer = answer.trim().toLowerCase();
    const correct = userAnswer === currentTask.correct_answer.toLowerCase();

    setIsCorrect(correct);
    setShowModal(true);

    if (correct) {
      setScore((s) => s + 1);
    }
  };

  const handleNext = async () => {
  setShowModal(false);
  setAnswer("");

  if (currentTaskIndex < tasks.length - 1) {
    setCurrentTaskIndex(currentTaskIndex + 1);
  } else {
    // Koristimo isCorrect koji je već postavljen, score je već ažuriran
    const finalScore = score; // score je već ažuriran u checkAnswer

    try {
      await progressAPI.update(lessonId, {
        score: finalScore,
        completed: true,
      });
    } catch (err) {
      console.error("Failed to save progress:", err);
    }

    alert(`Lesson completed! Your score: ${finalScore}/${tasks.length}`);
    navigate("/progress");
  }
};

  const renderTask = () => {
    switch (currentTask.type) {
      case "translate":
        return (
          <div>
            <p><strong>{currentTask.question}</strong></p>
            <input
              value={answer}
              onChange={(e) => setAnswer(e.target.value)}
              placeholder="Your answer"
              style={{
                width: "100%",
                padding: "10px",
                borderRadius: 4,
                border: "1px solid #ddd",
                marginTop: 12
              }}
            />
          </div>
        );

      case "audio":
        return (
          <div>
            {currentTask.audio_url && (
              <AudioPlayer
                src={currentTask.audio_url}
                label="Listen to the pronunciation"
              />
            )}
            <div style={{ marginTop: 16 }}>
              {currentTask.options?.map((option, idx) => (
                <div key={idx} style={{ marginBottom: 8 }}>
                  <label style={{ display: "flex", alignItems: "center", cursor: "pointer" }}>
                    <input
                      type="radio"
                      name="audio-answer"
                      value={option}
                      checked={answer === option}
                      onChange={(e) => setAnswer(e.target.value)}
                      style={{ marginRight: 8 }}
                    />
                    {option}
                  </label>
                </div>
              ))}
            </div>
          </div>
        );

      case "multiple-choice":
        return (
          <div>
            {currentTask.options?.map((option, idx) => (
              <div key={idx} style={{ marginBottom: 8 }}>
                <label style={{ display: "flex", alignItems: "center", cursor: "pointer" }}>
                  <input
                    type="radio"
                    name="mc-answer"
                    value={option}
                    checked={answer === option}
                    onChange={(e) => setAnswer(e.target.value)}
                    style={{ marginRight: 8 }}
                  />
                  {option}
                </label>
              </div>
            ))}
          </div>
        );

      default:
        return <p>Unknown task type</p>;
    }
  };

  return (
    <div className="container">
      <h1>Lesson {lessonId}</h1>

      <ProgressBar
        progress={progress}
        showLabel
        label={`Task ${currentTaskIndex + 1} of ${tasks.length}`}
        height={12}
      />

      <div className="card" style={{ marginTop: 20 }}>
        <h3>Task {currentTaskIndex + 1}</h3>
        <p>{currentTask.question}</p>

        {renderTask()}

        <div style={{ marginTop: 16 }}>
          <Button onClick={checkAnswer} disabled={!answer}>
            Check Answer
          </Button>
        </div>
      </div>

      {/* Modal za feedback */}
      <Modal
        isOpen={showModal}
        onClose={() => setShowModal(false)}
        title={isCorrect ? "✅ Correct!" : "❌ Incorrect"}
        footer={
          <Button onClick={handleNext}>
            {currentTaskIndex < tasks.length - 1 ? "Next Task" : "Finish Lesson"}
          </Button>
        }
      >
        <div>
          <p>
            {isCorrect
              ? "Great job! Your answer is correct."
              : `The correct answer is: ${currentTask.correct_answer}`
            }
          </p>
          {currentTask.explanation && (
            <p style={{ marginTop: 12, fontSize: 14, color: "#666" }}>
              <strong>Explanation:</strong> {currentTask.explanation}
            </p>
          )}
        </div>
      </Modal>
    </div>
  );
}