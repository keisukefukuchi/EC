<template>
  <div class="cart">
    <h1 class="cart__title">カート一覧</h1>
    <div class="cart__main">
      <div class="cart__content">
        <div class="cart-list" v-for="(cart, index) in cartList" :key="index">
          <div
            class="cart-list__img"
            :style="itemImg(cart.item.item_image[0].image_path)"
          ></div>
          <div class="cart-list__center">
            <p class="cart-list__name">{{ cart.item.name }}</p>
            <div class="cart-list__edit">
              <div class="quantity-input">
                <p class="quantity-input__label">計数：</p>
                <input
                  class="quantity-input__number"
                  type="number"
                  v-model="cart.quantity"
                  @change="updateQuantity(cart, index)"
                />
              </div>
              <p class="cart-list__delete" @click="removeCartList(cart, index)">
                削除する
              </p>
            </div>
          </div>
          <div class="cart-list__right">
            <p class="cart-list__price">
              ￥{{ cart.item.price.toLocaleString() }}
            </p>
          </div>
        </div>
      </div>
      <div v-if="cartList" class="cart__control">
        <div class="control">
          <p class="control__total-price">
            小計：¥{{ cartTotalPrice.toLocaleString() }}
          </p>
          <nuxt-link to="/purchasers/payment" class="control__button"
            ><div class="control__button-image"></div>
            ご購入手続き</nuxt-link
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: "purchasers",
  computed: {
    cartTotalPrice() {
      return this.$store.getters.cartTotalPrice;
    },
    cartList() {
      return this.$store.state.cartList;
    },
  },

  methods: {
    itemImg(path) {
      if (path == null) return;
      return `background-image: url(http://localhost:8000${path})`;
    },
    removeCartList(cart, index) {
      this.$store.dispatch("removeCartList", { cart, index });
    },
    updateQuantity(cart, index) {
      const validateCheck = /^([1-9]\d*|0)$/;
      if (cart.quantity != null && validateCheck.test(cart.quantity)) {
        this.$store.dispatch("updateQuantity", { cart, index });
      } else {
        return alert("正しい値を入力してください！");
      }
    },
  },

  mounted() {
    this.$store.dispatch("getCartList");
  },
};
</script>

<style lang="scss" scoped>
.cart {
  background-color: white;
  width: 90%;
  max-width: 1500px;
  margin: 0 auto;
  padding: 4rem 0;
  &__title {
    font-size: 2.8rem;
    padding-bottom: 1rem;
    font-weight: bold;
    border-bottom: 4px solid #c4c4c4;
    margin-bottom: 3.5rem;
  }
  &__main {
    display: flex;
    justify-content: space-between;
  }
  &__content {
    width: 70%;
  }
  &__control {
    width: 25%;
  }
}
.cart-list {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 2rem 1rem;
  border-bottom: 0.23rem solid #c4c4c4;
  &__img {
    width: 11rem;
    height: 11rem;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
  &__center {
    width: 35%;
  }
  &__right {
    width: 25%;
  }
  &__name {
    font-size: 2.3rem;
    font-weight: bold;
  }
  &__edit {
    display: flex;
    align-content: center;
    justify-content: space-between;
    margin-top: 3rem;
  }
  &__delete {
    font-size: 0.8rem;
    color: #c4c4c4;
    &:hover {
      cursor: pointer;
    }
  }
  &__price {
    font-size: 2rem;
    font-weight: bold;
    margin: 1rem 0 0 1.5rem;
  }
}
.quantity-input {
  display: flex;
  font-size: 0.8rem;
  background-color: #efefef;
  padding: 0.2rem 0.3rem;
  &__label {
  }
  &__number {
    width: 2.3rem;
  }
}
.control {
  background-color: #f5f3e9;
  text-align: center;
  border-radius: 0.8rem;
  padding: 3rem 2rem;
  &__total-price {
    font-size: 2rem;
  }
  &__button {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 90%;
    font-size: 1.4rem;
    margin: 3rem auto 0;
    padding: 0.5rem 0.8rem;
    color: white;
    background-color: #218060;
    border-radius: 0.5rem;
  }
  &__button-image {
    width: 2.4rem;
    height: 2.4rem;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-image: url("~/assets/img/cart-white.png");
  }
}
</style>
