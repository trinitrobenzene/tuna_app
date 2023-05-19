import { computed, reactive } from "vue";

const userState = reactive({
  isLogin: false,
  info: null,
});

const setUserState = (payload) => {
  userState.isLogin = payload ? true : false;
  userState.info = payload ? payload : null;
};

export default {
  isLogin: computed(() => userState.isLogin),
  user: computed(() => userState.info),
  setUserState,
};
