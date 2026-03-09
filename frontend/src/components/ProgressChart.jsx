import React from "react";
import {
  ResponsiveContainer,
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend
} from "recharts";

const data = [
  { course: "English", progress: 80 },
  { course: "Spanish", progress: 55 },
  { course: "German", progress: 35 }
];

export default function ProgressChart() {
  return (
    <div style={{ width: "100%", height: 350, marginTop: "20px" }}>
      <h2>Course Progress Overview</h2>

      <ResponsiveContainer width="100%" height="100%">
        <BarChart data={data} margin={{ top: 20, right: 30, left: 0, bottom: 5 }}>
          <CartesianGrid strokeDasharray="3 3" />
          <XAxis dataKey="course" />
          <YAxis domain={[0, 100]} />
          <Tooltip />
          <Legend />
          <Bar dataKey="progress" name="Progress (%)" fill="#8884d8" />
        </BarChart>
      </ResponsiveContainer>
    </div>
  );
}