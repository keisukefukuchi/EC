<template>
  <div class="item-all">
    <div class="item-all__header">
      <h1 class="item-all__title">商品一覧</h1>
      <nav class="item-all__pub">
        <li class="item-all__nav" :style="navStyle(2)" @click="settingPub = 2">
          全商品
        </li>
        <li class="item-all__nav" :style="navStyle(1)" @click="settingPub = 1">
          公開中商品
        </li>
        <li class="item-all__nav" :style="navStyle(0)" @click="settingPub = 0">
          非公開商品
        </li>
      </nav>
    </div>
    <div class="item-all__content-box">
      <div
        class="item"
        v-for="content in viewContent"
        @click="$router.push('/sellers/item/edit/' + content.id)"
        :key="content.id"
      >
        <div
          class="item__img"
          :style="itemImg(content.item_image[0].image_path)"
        ></div>
        <p class="item__title">{{ content.name }}</p>
        <p class="item__price">¥{{ content.price.toLocaleString() }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: "sellers",

  data() {
    return {
      contents: null,
      settingPub: 2,
      pub: { 0: [0], 1: [1], 2: [0, 1] },
    };
  },
  computed: {
    viewContent: function () {
      if (this.contents == null) return;
      return this.contents.filter(function (content) {
        return this.pub[this.settingPub].includes(content.public);
      }, this);
    },
  },
  methods: {
    navStyle(id) {
      if (id == this.settingPub) return "border-bottom: 5px solid #3c9b9a;";
    },
    async getUserItems() {
      await this.$axios
        .get("http://localhost:8000/api/item", {
          withCredentials: true,
        })
        .then((response) => {
          this.contents = response.data;
        });
    },
    itemImg(path) {
      if (path == null) return;
      return `background-image: url(http://localhost:8000${path})`;
    },
  },

  async mounted() {
    this.getUserItems();
  },
};
</script>

<style lang="scss" scoped>
.item-all {
  &__header {
    background-color: white;
    padding: 0.8rem 1.2rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
  }
  &__title {
    font-size: 2.5rem;
  }
  &__pub {
    display: flex;
  }
  &__nav {
    list-style: none;
    margin-left: 1.8rem;
    font-size: 1.2rem;
    font-weight: bold;
    &:hover {
      cursor: pointer;
    }
  }
  &__content-box {
    margin-top: 2.3rem;
    background-color: white;
    padding: 2rem 2rem;
    display: flex;
    flex-wrap: wrap;
  }
}
.item {
  width: 25%;
  padding: 3rem 2rem 1.6rem;
  border-bottom: 1px solid #c4c4c4;
  &:hover {
    cursor: pointer;
  }
  &__img {
    padding-top: 100%;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
  }
  &__title {
    font-size: 1.5rem;
    margin-top: 1.1rem;
  }
  &__price {
    margin-top: 0.7rem;
    font-size: 1.5rem;
    font-weight: bold;
  }
}
</style>
