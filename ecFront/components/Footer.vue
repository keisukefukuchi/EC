<template>
  <div class="footer">
    <div class="footer__content">
      <nav class="menu-box">
        <p class="menu-box__title">Freshsについて</p>
        <nuxt-link class="menu-box__link" to="/">トップ</nuxt-link>
        <nuxt-link class="menu-box__link" to="/purchasers/about"
          >about</nuxt-link
        >
        <nuxt-link class="menu-box__link" to="/">利用規約</nuxt-link>
        <nuxt-link class="menu-box__link" to="/"
          >プライバシーポリシー</nuxt-link
        >
      </nav>
      <nav class="menu-box">
        <p class="menu-box__title">商品を探す</p>
        <nuxt-link class="menu-box__link" to="/purchasers/itemList"
          >全ての商品一覧</nuxt-link
        >
        <nuxt-link class="menu-box__link" to="/">旬の商品</nuxt-link>
        <nuxt-link class="menu-box__link" to="/">全てのフルーツ</nuxt-link>
        <nuxt-link class="menu-box__link" to="/">全ての野菜</nuxt-link>
      </nav>
      <nav class="menu-box">
        <p class="menu-box__title">メニュー</p>
        <nuxt-link class="menu-box__link" to="/purchasers/register"
          >会員登録</nuxt-link
        >
        <nuxt-link class="menu-box__link" to="/purchasers/login"
          >ログイン</nuxt-link
        >
        <nuxt-link class="menu-box__link" to="/purchasers/mypage"
          >マイページ</nuxt-link
        >
        <nuxt-link class="menu-box__link" to="/purchasers/cart"
          >カート</nuxt-link
        >
      </nav>
    </div>
    <p class="footer__copy">2021@freshs</p>
  </div>
</template>
<style lang="scss" scoped>
.footer {
  background-color: #218060;
  padding: 3rem 5rem;
  color: white;
  &__content {
    display: flex;
  }
  &__copy {
    margin-top: 2rem;
    text-align: right;
    font-size: 1.4rem;
    font-weight: bold;
  }
}
.menu-box {
  margin-right: 10rem;
  &__title {
    font-size: 1.4rem;
    margin-bottom: 1rem;
    font-weight: bold;
  }
  &__link {
    margin-bottom: 1rem;
    display: block;
    padding-left: 1rem;
    font-size: 1rem;
  }
}
</style>
