import { createStore } from 'vuex'
import router from '../router'
import axios from 'axios'

axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';

let api = 'http://127.0.0.1:8000/api'

export default createStore({
  state: {
    posts: [],
    user: {},
    table_data: [],
    _alert: {
      flag: false,
      message: null
    },
    admin_edit: false
  },
  mutations: {
    setPosts(state, data) {
      state.posts = data
    },
    setUser(state, data) {
      state.user = data
    },
    SET_AlertFlag(state, value) {
      state._alert.flag = value;
    },
    SET_ALERT(state, data) {
      state._alert = {
        flag: true,
        type: data[0],
        message: data[1]
      }
    },
    SET_Table(state, data) {
      state.table_data = data;
    },
    SET_EditAdmin(state, value) {
      state.admin_edit = value;
    }
  },
  actions: {
    setAlertFlag({commit}, value) {
      commit('SET_AlertFlag', value);
    },

    setAlert({commit}, value) {
      commit('SET_ALERT', ['message', value]);
    },

    readTable({commit}, data) {
      axios({
        method: "get",
        url: `${api}/${data.table}/index?user_id=${data.id}`,
        headers: {
          'Content-type': "application/json; charset=UTF-8",
          'Authorization': `Bearer ${localStorage.token.substr(1, localStorage.token.length-2)}`
        }
      }).then(res => {
        console.log(res.data);
        commit('SET_Table', res.data);
      }).catch(error => {
        console.log(error);
      });
    },

    deleteRow({commit}, data) {
      console.log('!!!');
      axios({
        method: "get",
        url: `${api}/${data.table}/delete/${data.id}`,
        headers: {
          'Content-type': "application/json; charset=UTF-8",
          'Authorization': `Bearer ${localStorage.token.substr(1, localStorage.token.length-2)}`
        }
      }).then(res => {
        console.log(res.data);
        commit('SET_EditAdmin', true)
        commit('SET_ALERT', ['message', "Удалено"]);
      }).catch(error => {
        console.log(error);
      });
    },

    updateRow({commit}, data) {
      axios({
        method: "get",
        url: `${api}/${data.table}/update/${data.id}`,
        headers: {
          'Content-type': "application/json; charset=UTF-8",
          'Authorization': `Bearer ${localStorage.token.substr(1, localStorage.token.length-2)}`
        }
      }).then(res => {
        console.log(res.data);
        commit('SET_EditAdmin', true)
        commit('SET_ALERT', ['message', 'Обновлено']);
      }).catch(error => {
        console.log(error);
      });
    },

    isAuth({commit}) {
      function isEmpty(obj) {
        for (let key in obj) {
          return false;
        }
        return true;
      }
      if (!isEmpty(localStorage.getItem('user'))) {
        commit('setUser', JSON.parse(localStorage.getItem('user')));
      }
    },

    getPosts({commit}) {
      axios.get(`${api}/posts/all`).then(res => {
        commit('setPosts', res.data.body.posts);
      }).catch(error => {
        commit('SET_ALERT', ['message', error]);
      })
    },

    Register({commit}, data) {
      axios({
        method: 'post',
        url: `${api}/users/create`,
        data: data,
        headers: {
          "Content-type": "application/json; charset=UTF-8"
        }
      }).then(res => {
        if (res.data.status) {
          commit('SET_ALERT', ['message', res.data.body.message]);
          router.push('/login');
        } else {
          commit('SET_ALERT', ['message', res.data.body]);
        }
      }).catch(error => {
        console.log(error);
        commit('SET_ALERT', ['message', 'Пользователь с такой почтой существует']);
      })
    },

    Login({commit}, data) {
      axios({
        method: 'post',
        url: `${api}/users/login`,
        data: data,
        headers: {
          "Content-type": "application/json; charset=UTF-8"
        }
      }).then(res => {
        if (res.data.status) {
          console.log(res.data.body.user);
          commit('setUser', res.data.body.user);
          localStorage.setItem('user', JSON.stringify(res.data.body.user))
          localStorage.setItem('token', JSON.stringify(res.data.body.token))
          commit('SET_ALERT', ['message', 'Авторизазия прошла успешно']);
          router.push('/');
        } else {
          commit('SET_ALERT', ['message', res.data.body]);
        }
      }).catch(error => {
        console.log(error.response.data);
      })
    },

    exit({commit}, data) {
      axios({
        method: "get",
        url: `${api}/users/logout?user_id=${data.id}`,
        headers: {
          'Content-type': "application/json; charset=UTF-8",
          'Authorization': `Bearer ${localStorage.token.substr(1, localStorage.token.length-2)}`
        }
      }).then(res => {
        commit('setUser', {});
        localStorage.removeItem('user');
        localStorage.removeItem('token');
        router.push('/')
        commit('SET_ALERT', ['message', res.data.body.message]);
      }).catch(error => {
        console.log(error);
      });
    }

  },
  modules: {
  }
})
