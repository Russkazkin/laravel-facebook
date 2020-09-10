const state = {
    user: null,
    userStatus: null,
};
const getters = {
    authUser: state => {
        return state.user;
    }
};
const actions = {
    async fetchAuthUser({commit, state}){
        try {
            const authUser = (await axios.get('/api/auth-user')).data;
            commit("setAuthUser", authUser);
        } catch (error) {
            console.log('Unable to fetch auth user, ' + error.status);
        } finally {

        }
    }
};
const mutations = {
    setAuthUser(state, user) {
        state.user = user;
    }
};

export default { state, getters, actions, mutations };
