import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";

const store = () => {
  return new Vuex.Store({
    state: {
      isLogin: false,
      loginUser: null,

      cartList: [],
    },
    mutations: {
      updateIsLogin(state, payload) {
        state.isLogin = payload;
      },
      updateLoginUser(state, payload) {
        state.loginUser = payload;
      },

      destroyCart(state) {
        state.cartList = [];
      },
      setCartList(state, items) {
        state.cartList = [];
        let cartList = state.cartList;
        for (let i = 0; i < items.length; i++) {
          cartList.push({
            id: items[i].id, //cartのid
            item: {
              id: items[i].item.id,
              name: items[i].item.name,
              price: items[i].item.price,
              item_image: items[i].item.item_image,
            },
            quantity: items[i].quantity,
          });
        }
      },
      removeCartList(state) {
        state.cartList = [];
      },
    },
    actions: {
      //購入者ページのミドルウェアで実行。ログインしているかチェックし、ログイン情報をstateに保存する
      async updateLoginPurchaserUser(context) {
        await this.$axios
          .get("http://localhost:8000/api/purchaser/user", {
            withCredentials: true,
          })
          .then((res) => {
            context.commit("updateLoginUser", res.data);
            context.commit("updateIsLogin", true);
            // context.dispatch("getCartList");
          })
          .catch(() => {
            context.commit("updateIsLogin", false);
            context.commit("updateLoginUser", null);
            context.commit("removeCartList");
          });
      },

      //出品者ページのミドルウェアで実行。ログインしているかチェックし、ログイン情報をstateに保存する
      async updateLoginSellerUser(context) {
        await this.$axios
          .get("http://localhost:8000/api/seller/user", {
            withCredentials: true,
          })
          .then(async (res) => {
            context.commit("updateIsLogin", true);
            context.commit("updateLoginUser", res.data);
          })
          .catch(() => {
            context.commit("updateIsLogin", false);
            context.commit("updateLoginUser", null);
          });
      },

      //購入者のカート情報を取得し、stateに保存
      async getCartList(context) {
        console.log(context.state.loginUser.id);
        const resData = await this.$axios.get(
          "http://localhost:8000/api/cart/show/" + context.state.loginUser.id,
          { withCredentials: true }
        );
        console.log(resData.data);
        context.commit("setCartList", resData.data);
        console.log(context.state.cartList);
      },

      async addCartList(context, item) {
        // context.commit("setCartList", item);
        const sendData = {
          purchaser_id: context.state.loginUser.id,
          item_id: item.id,
          quantity: item.quantity,
        };
        const cartList = context.state.cartList;
        const cartItem = cartList.find(
          (cart) => cart.item.id === sendData.item_id
        );
        if (!cartItem) {
          await this.$axios.post(
            "http://localhost:8000/api/cart/add",
            sendData,
            { withCredentials: true }
          );
        } else {
          await this.$axios.post(
            "http://localhost:8000/api/cart/plus",
            sendData,
            { withCredentials: true }
          );
        }
        // context.commit("addCartList", item);
      },

      async removeCartList(context, { cart, index }) {
        const sendData = {
          id: cart.id,
        };
        // context.commit("removeItem", { item, index });
        await this.$axios.post(
          "http://localhost:8000/api/cart/destroy",
          sendData,
          { withCredentials: true }
        );
        context.dispatch("getCartList");
      },

      async updateQuantity(context, { cart, index }) {
        const sendData = {
          id: cart.id, //cartのid
          quantity: cart.quantity,
        };
        // context.commit("changeQuantity", { item, index });
        await this.$axios.post(
          "http://localhost:8000/api/cart/update",
          sendData,
          { withCredentials: true }
        );
        context.dispatch("getCartList");
      },

      async purchase(context, id) {
        const sendData = {
          purchaser_id: id,
        };
        await this.$axios.post(
          "http://localhost:8000/api/cart/purchase",
          sendData,
          { withCredentials: true }
        );
        context.dispatch("getCartList");
      },
    },
    getters: {
      cartTotalPrice(state, getters) {
        return state.cartList.reduce((total, product) => {
          return total + product.item.price * product.quantity;
        }, 0);
      },
    },
    plugins: [createPersistedState({ key: "EC-study" })],
  });
};

export default store;
