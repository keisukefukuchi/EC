export default async ({ store, redirect }) => {
  await store.dispatch("updateLoginSellerUser");
  if (store.state.loginUser == null) redirect("/sellers/login");
};
