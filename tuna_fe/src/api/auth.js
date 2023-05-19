import axios from "axios";

export async function login(userInfo) {
  return await axios.post("http://localhost:8000/api/login", userInfo);
}

export async function logout() {
  return await axios.get("http://localhost:8000/api/logout");
}

export async function register(userInfo) {
  return await axios.post('http://localhost:8000/api/register', userInfo)
}
