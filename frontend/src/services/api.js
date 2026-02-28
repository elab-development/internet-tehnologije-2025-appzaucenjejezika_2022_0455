import axios from 'axios';

const API_URL = 'http://localhost:8000/api';

const api = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
  }
});

// Dodaj token u svaki zahtev
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Auth API
export const authAPI = {
  login: (email, password) => api.post('/login', { email, password }),
  register: (name, email, password) => api.post('/register', { name, email, password }),
  logout: () => api.post('/logout'),
  me: () => api.get('/me'),
};

// Courses API
export const coursesAPI = {
  getAll: () => api.get('/courses'),
  getById: (id) => api.get(`/courses/${id}`),
  create: (data) => api.post('/courses', data),
};

// Lessons API
export const lessonsAPI = {
  getByCourse: (courseId) => api.get(`/courses/${courseId}/lessons`),
};

// Tasks API
export const tasksAPI = {
  getByLesson: (lessonId) => api.get(`/lessons/${lessonId}/tasks`),
  create: (data) => api.post('/tasks', data),
  update: (id, data) => api.patch(`/tasks/${id}`, data),
  delete: (id) => api.delete(`/tasks/${id}`),
};

// Progress API
export const progressAPI = {
  getByUser: () => api.get('/progress'),
  update: (lessonId, data) => api.post('/progress', {  lesson_id: lessonId,     ...data 
  }),
};

export default api;
