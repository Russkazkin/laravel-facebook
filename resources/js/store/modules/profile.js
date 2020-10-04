const state = {
    user: false,
    userStatus: null,
};
const getters = {
    user: state => {
        return state.user;
    },
    userStatus: state => {
        return state.userStatus;
    },

    friendship: state => {
        return state.user.data.attributes.friendship;
    },
    friendButtonText: (state, getters, rootState) => {
        if(getters.friendship === null){
            return "Add Friend";
        }else if(
            getters.friendship.data.attributes.confirmed_at === null
            && getters.friendship.data.attributes.friend_id !== rootState.user.user.data.user_id
        ) {
            return  "Pending Friend Request";
        }
        return 'Accept';
    }
};
const actions = {
    async fetchUser({commit, dispatch}, userId){
        commit("setUserStatus", "loading");
        try {
            const user = (await axios.get('/api/users/' + userId)).data;
            commit("setUser", user);
            commit("setUserStatus", "success");

        } catch (error) {
            console.log('Unable to fetch data, ' + error.response.status);
            commit("setUserStatus", "error");
        } finally {
            this.loading = false;
        }
    },

    async sendFriendRequest({commit, state}, friend_id) {
        try {
            const friendship = (await axios.post('/api/friend-request', { 'friend_id': friend_id })).data;
            commit("setUserFriendship", friendship);
        } catch (e) {
            console.error(e.response.data.message);
        } finally {

        }
    },
     async acceptFriendRequest({commit, state}, user_id) {
        try {
            const friendship = (await axios.post('/api/friend-request-response', { 'user_id': user_id })).data;
            commit("setUserFriendship", friendship);
        } catch (e) {
            console.error(e.response.data.message);
        } finally {

        }
    },
    async ignoreFriendRequest({commit, state}, user_id) {
        try {
            const friendship = (await axios.delete('/api/friend-request-response/delete', { data: {'user_id': user_id }})).data;
            commit("setUserFriendship", friendship);
        } catch (e) {
            console.error(e.response.data.message);
        } finally {

        }
    },

};
const mutations = {
    setUser(state, user) {
        state.user = user;
    },
    setUserFriendship(state, friendship) {
        state.user.data.attributes.friendship = friendship;
    },
    setUserStatus(state, status) {
        state.userStatus = status;
    },
};

export default { state, getters, actions, mutations };
