const state = {
    title: 'Welcome',
};
const getters = {
    pageTitle: state => state.title,
};
const actions = {
    setPageTitle({commit, state}, title) {
        commit('setTitle', title);
    },
};
const mutations = {
    setTitle(state, title) {
        state.title = title + ' | Facebook';
    }
};

export default {state, getters, actions, mutations};
