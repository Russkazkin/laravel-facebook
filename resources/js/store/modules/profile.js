const state = {
    user: false,
    userStatus: null,
    friendButtonText: 'Add Friend',
};
const getters = {
    user: state => {
        return state.user;
    },
    friendButtonText: state => {
        return state.friendButtonText;
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
    },
    async sendFriendRequest({commit, state}, userId) {
        commit("setButtonText", "Loading...");
    }
};
const mutations = {
    setUser(state, user) {
        state.user = user;
    },
    setUserStatus(state, status) {
        state.userStatus = status;
    },
    setButtonText(state, text) {
        state.friendButtonText = text;
    },


};

export default { state, getters, actions, mutations };
