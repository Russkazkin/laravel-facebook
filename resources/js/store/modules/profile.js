const state = {
    user: false,
    userStatus: null,
    friendButtonText: null,
};
const getters = {
    user: state => {
        return state.user;
    },
    friendship: state => {
        return state.user.data.attributes.friendship;
    },
    friendButtonText: state => {
        return state.friendButtonText;
    }
};
const actions = {
    async fetchUser({commit, dispatch}, userId){
        try {
            const user = (await axios.get('/api/users/' + userId)).data;
            commit("setUser", user);
            dispatch("setFriendButton");
        } catch (error) {
            console.log('Unable to fetch data, ' + error.status);
        } finally {
            this.loading = false;
        }
    },

    async sendFriendRequest({commit, state}, friend_id) {
        commit("setButtonText", "Loading...");

        try {
            await axios.post('/api/friend-request', { 'friend_id': friend_id });
            commit("setButtonText", "Pending Friend Request");
        } catch (e) {
            commit("setButtonText", "Add Friend");
        } finally {

        }
    },

    setFriendButton({commit, getters}){
        if(getters.friendship === null){
            commit("setButtonText", "Add Friend");
        }else if(getters.friendship.data.attributes.confirmed_at === null) {
            commit("setButtonText", "Pending Friend Request");
        }
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
