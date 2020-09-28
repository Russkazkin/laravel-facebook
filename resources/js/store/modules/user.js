const state = {
    user: false,
    userStatus: null,
};
const getters = {
    user: state => {
        return state.user;
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
    setAuthUser(state, user) {
        state.user = user;
    }
};

export default { state, getters, actions, mutations };
