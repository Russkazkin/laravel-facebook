const state = {
    authUser: false,
    userStatus: null,
};
const getters = {
    authUser: state => {
        return state.authUser;
    }
};
const actions = {
    async fetchAuthUser({commit, state}){
        commit("setUserStatus", "loading");
        try {
            const authUser = (await axios.get('/api/auth-user')).data;
            commit("setAuthUser", authUser);
            commit("setUserStatus", "success");
        } catch (error) {
            commit("setUserStatus", "error");
        }
    }
};
const mutations = {
    setAuthUser(state, authUser) {
        state.authUser = authUser;
    }
};

export default { state, getters, actions, mutations };
