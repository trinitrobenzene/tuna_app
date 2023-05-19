import axios from "axios";

export const sendAd = async (id) => {
  return await axios.post("http://localhost:8000/api/send-mail", {
    receiver_id: id,
  });
};
