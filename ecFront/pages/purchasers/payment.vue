<template>
  <div class="payment">
    <h1 class="payment__title">お支払い方法</h1>
    <div class="payment__box">
      <h2 class="payment__sub-title">お届け先</h2>
      <p class="payment__user-name">
        {{ this.$store.state.loginUser.name }} 様
      </p>
      <p class="payment__user-address">
        {{ this.$store.state.loginUser.address }}
      </p>
    </div>
    <div class="payment__box">
      <h2 class="payment__sub-title">商品情報</h2>
      <div class="payment__item-box">
        <div class="item" v-for="(cart, index) in cartList" :key="index">
          <div
            class="item__image"
            :style="itemImg(cart.item.item_image[0].image_path)"
          ></div>
          <div class="item__info">
            <p class="item__name">{{ cart.item.name }}</p>
            <p class="item__price">¥{{ cart.item.price.toLocaleString() }}</p>
            <label class="item__quantity">
              数量：
              <input
                class="item__input"
                type="number"
                v-model="cart.quantity"
              />
            </label>
          </div>
        </div>
      </div>
    </div>
    <div class="payment__box">
      <h2 class="payment__sub-title">決済方法</h2>
    </div>
    <div class="payment__box">
      <h2 class="payment__sub-title">注文内容</h2>
      <div class="payment__payment-box">
        <div class="point">
          <div class="point__row">
            <p>使用可能ポイント</p>
            <p>{{ point }}</p>
          </div>
          <div class="point__row">
            <p class="point__label">利用ポイント</p>
            <input type="number" v-model="used_point" />
          </div>
        </div>
        <div class="price">
          <dl>
            <div class="price__list">
              <dt>商品の小計：</dt>
              <dd>¥{{ cartTotalPrice.toLocaleString() }}</dd>
            </div>
            <div class="price__list">
              <dt>ポイント：</dt>
              <dd>-¥{{ used_point.toLocaleString() }}</dd>
            </div>
            <div class="price__sum">
              <dt>請求額：</dt>
              <dd>¥{{ (cartTotalPrice - used_point).toLocaleString() }}</dd>
            </div>
          </dl>
        </div>
      </div>

      <button
        class="payment__button"
        @click="purchase($store.state.loginUser.id, cartList)"
      >
        購入する
      </button>
    </div>
  </div>
</template>

<script>
export default {
  layout: "purchasers",

  data() {
    return {
      used_point: 0,
      total: 0,
      get_point: 0,
      point: this.$store.state.loginUser.point.point,
    };
  },

  computed: {
    cartList() {
      return this.$store.state.cartList;
    },
    cartTotalPrice() {
      return this.$store.getters.cartTotalPrice;
    },
  },

  methods: {
    itemImg(path) {
      if (path == null) return;
      return `background-image: url(http://localhost:8000${path})`;
    },
    updateQuantity(cart, index) {
      const validateCheck = /^([1-9]\d*|0)$/;
      if (cart.quantity != null && validateCheck.test(cart.quantity)) {
        this.$store.dispatch("updateQuantity", { cart, index });
      } else {
        return alert("正しい値を入力してください！");
      }
    },
    async purchase(id, item) {
      if (!item) return;
      if (this.point < this.used_point) return;
      this.total = this.cartTotalPrice - this.used_point;
      this.get_point = Math.floor(this.total * 0.1);
      this.point = this.point + this.get_point;
      let S = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      let F = 4;
      let M = 4;
      let L = 4;
      let First = Array.from(Array(F))
        .map(() => S[Math.floor(Math.random() * S.length)])
        .join("");
      let Middle = Array.from(Array(M))
        .map(() => S[Math.floor(Math.random() * S.length)])
        .join("");
      let Last = Array.from(Array(L))
        .map(() => S[Math.floor(Math.random() * S.length)])
        .join("");
      const orderId = First + "-" + Middle + "-" + Last;
      const conveyData = {
        order_id: orderId,
        purchaser_id: id,
        amount: this.cartTotalPrice,
        destination: this.$store.state.loginUser.address,
        total: this.total,
        used_point: this.used_point,
        get_point: this.get_point,
        point: this.point,
        items: item.map((item) => {
          return { item_id: item.id, quantity: item.quantity };
        }),
      };
      await this.$axios.post(
        "http://localhost:8000/api/purchase/store",
        conveyData,
        { withCredentials: true }
      );
      for (let i = 0; i < item.length; i++) {
        const sendData = {
          order_id: orderId,
          quantity: item[i].quantity,
          item_id: item[i].item.id,
        };
        await this.$axios.post(
          "http://localhost:8000/api/history/store",
          sendData,
          { withCredentials: true }
        );
      }
      this.$store.dispatch("purchase", id);
      this.$router.push({ name: "purchasers-thanks", params: { orderId } });
    },
  },
};
</script>

<style lang="scss" scoped>
.payment {
  background-color: white;
  width: 90%;
  max-width: 1300px;
  margin: 0 auto;
  padding: 4rem 0;
  &__title {
    font-size: 2.8rem;
    padding-bottom: 1rem;
    font-weight: bold;
    border-bottom: 4px solid #c4c4c4;
    margin-bottom: 3.5rem;
  }
  &__box {
    width: 90%;
    margin: 0 auto;
    border-bottom: 0.2rem solid #c4c4c4;
    padding: 0.9rem 0;
  }
  &__sub-title {
    font-size: 1.4rem;
    margin-bottom: 0.9rem;
    font-weight: bold;
  }
  &__user-name {
    margin-left: 2rem;
  }
  &__user-address {
    margin-left: 2rem;
  }
  &__item-box {
    width: 95%;
    margin: 0 auto;
    border: 0.2rem solid #c4c4c4;
    display: flex;
    flex-wrap: wrap;
  }
  &__payment-box {
    width: 90%;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
  }
  &__button {
    background-color: #218060;
    display: inline-block;
    padding: 0.9rem 2rem;
    border-radius: 0.9rem;
    color: white;
    &:hover {
      cursor: pointer;
    }
  }
}
.item {
  display: flex;
  justify-content: space-between;
  width: 50%;
  padding: 2rem 1rem;

  &__image {
    width: 10.2rem;
    height: 10.2rem;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
  &__info {
    width: calc(100% - 14rem);
  }
  &__name {
    font-size: 2rem;
  }
  &__price {
  }
  &__quantity {
    display: flex;
    align-items: center;
  }
  &__input {
    width: calc(100% - 4rem);
  }
}
.point {
  &__row {
    display: flex;
    margin-bottom: 2rem;
  }
}
.price {
  width: 40%;
  &__list {
    font-size: 0.9rem;
    display: flex;
    justify-content: space-between;
    padding: 0.6rem 0 0.6rem 1.2rem;
  }
  &__sum {
    font-size: 1.8rem;
    display: flex;
    justify-content: space-between;
    border-top: 0.2rem solid #218060;
    padding: 0.6rem 0 0.6rem 1.2rem;
  }
}
</style>
