<template>
  <div class="thanks">
    <p class="thanks__name">{{ $store.state.loginUser.name }} 様</p>
    <p class="thanks__message">
      誠にありがとうございます。ご注文が完了しました。
    </p>
    <div class="thanks__box">
      <p class="thanks__id-message">
        注文番号は<span class="thanks__id">{{ $route.params.orderId }}</span
        >です。
      </p>
      <p class="thanks__attention">
        注文内容と配送状況についてはEメールでお知らせをご確認ください。
      </p>
      <nuxt-link class="thanks__button" to="/">ショッピングを続ける</nuxt-link>
    </div>
  </div>
</template>

<script>
export default {
  layout: "purchasers",
};
</script>

<style lang="scss" scoped>
.thanks {
  text-align: center;
  padding: 14rem 0;
  width: 60%;
  max-width: 90rem;
  margin: 0 auto;

  font-size: 1.2rem;
  &__name {
    font-size: 3rem;
    margin-bottom: 2rem;
  }
  &__message {
    margin-bottom: 2rem;
  }
  &__box {
    background-color: #f5f3e9;
    padding: 2rem 5rem;
    border-radius: 1rem;
  }
  &__id-message {
    margin-bottom: 1.4rem;
  }
  &__id {
    font-weight: bold;
  }
  &__attention {
    margin-bottom: 2.5rem;
  }
  &__button {
    background-color: #218060;
    color: white;
    padding: 0.8rem 1.4rem;
    border-radius: 0.6rem;
  }
}
</style>
