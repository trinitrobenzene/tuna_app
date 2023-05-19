import axios from "axios";

export const getAllUser = async () => {
  try {
    const resp = await axios.get("http://localhost:8000/api/user");
    if (resp.status === 200) {
      return resp.data;
    }
  } catch (error) {
    console.error(error);
  }
};

export const getAnUser = async (id) => {
  try {
    const resp = await axios.get(`http://localhost:8000/api/user/${id}`);
    return resp.data;
  } catch (error) {
    return error;
  }
};

export const createNewUser = async (user) => {
  try {
    const resp = await axios.post("http://localhost:8000/api/user", user);
    if (resp.status === 200) {
      return "success";
    }
  } catch (error) {
    return error.response.data;
  }
};

export const updateUser = async (user, id) => {
  try {
    const resp = await axios.patch(
      `http://localhost:8000/api/user/${id}`,
      user
    );
    return resp.statusText;
  } catch (error) {
    return error.response.data;
  }
};

export const removeUser = async (id) => {
  try {
    const resp = await axios.delete(`http://localhost:8000/api/user/${id}`);
    return resp.statusText;
  } catch (error) {
    return error.response.data;
  }
};

export const exportAllUser = (filename = "users") => {
  window.location.href = `http://localhost:8000/api/user/export/${filename}`;
};
