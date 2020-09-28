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
    async fetchUser({commit, state}, userId){
        try {
            const user = (await axios.get('/api/users/' + userId)).data;
            commit("setUser", user);
        } catch (error) {
            console.log('Unable to fetch data, ' + error.status)
        } finally {
            this.loading = false;
        }
    }
};
const mutations = {
    setUser(state, user) {
        state.user = user;
    },
    setUserStatus(state, status) {
        state.userStatus = status;
    }

};

export default { state, getters, actions, mutations };
