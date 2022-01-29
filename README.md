# :blush:phase3-EC:blush:

教材開発：EC サイト

## 必要作業

### フロント nuxt

```sh
yarn && yarn dev
```

### バック laravel

```sh
cp .env.example .env
```

.env ファイルの DB 設定を編集
.env ファイルの STRIPE_SECRET_KEY を設定

```sh
composer update
composer require stripe/stripe-php
php artisan storage:link
php artisan migrate:fresh
php artisan db:seed
php artisan key:generate
php artisan serve
```

## ダミー情報

| 購入者アカウント  | 出品者アカウント |
| :---------------- | :--------------- |
| shin@shin.com     | nabe@nabe.com    |
| motida@motida.com | honda@honda.com  |
| tome@tome.com     | kishi@kishi.com  |

**アカウントのパスワードは「password」です。**

1〜3 番目の商品には数件のレビューがされています。<br>

## Stripeへの登録

[こちら](https://stripe.com/jp)からStripeのアカウントを登録してください。
「開発者」→「APIキー」からSTRIPE_SECRET_KEYとSTRIPE_PUBLIC_KEYを確認することが可能です。
.envに二つのキーを確認して、記述してください。
```.env
STRIPE_PUBLIC_KEY=pk_test_xxxxx
STRIPE_SECRET_KEY=sk_test_xxxxx
```
## ページ一覧

<details><summary>購入者用</summary>

| パス                                  | ページ                   | メモ                                                                                                           |
| :------------------------------------ | :----------------------- | :------------------------------------------------------------------------------------------------------------- |
| /                                     | ホーム画面               | アプリのメイン画面                                                                                             |
| /purchasers/register                  | 新規登録                 | 登録後自動でログインし、ホーム画面に遷移                                                                       |
| /purchasers/login                     | ログイン画面             | ログイン後ホーム画面に遷移                                                                                     |
| /purchasers/about                     | アプリ説明               |                                                                                                                |
| /purchasers/itemList                  | 商品一覧ページ           | 商品をクリック → 商品詳細ページ                                                                                |
| /purchasers/itemDetail/{商品 id}      | 商品詳細ページ           | URL の id に対応した商品情報を表示<br>カート追加機能<br>お気に入り登録機能<br>レビュー作成ページへの遷移ボタン |
| /purchasers/review/{商品 id}          | レビュー作成ページ       | URL の id に対応した商品にレビューを書く                                                                       |
| /purchasers/cart                      | カートページ             | カートの中身確認<br>購入手続きページへの遷移ボタン                                                             |
| /purchasers/payment                   | 決済ページ               | ボタンクリックで決済完了<br>決済後はサンクスページに自動遷移                                                   |
| /purchasers/thanks                    | サンクスページ           | 買ってくれてありがとう                                                                                         |
| /purchasers/orderList                 | 注文履歴一覧ページ       | 注文詳細ページへの遷移ボタン<br>レビュー作成ページへの遷移ボタン                                               |
| /purchasers/orderDetail/{注文履歴 id} | 注文履歴詳細ページ       | URL の id に対応した注文履歴の表示<br>レビュー作成ページへの遷移ボタン                                         |
| /purchasers/point                     | ポイント履歴一覧ページ   |                                                                                                                |
| /purchasers/mypage                    | ユーザーメインページ     | ユーザー詳細、お気に入り、カート、注文履歴、ポイント履歴への遷移<br>ログアウト機能                             |
| /purchasers/mypage-detail             | ユーザー詳細ページ       | ユーザーの詳細情報表示<br>ユーザー情報編集                                                                     |
| /purchasers/favorite                  | お気に入り商品一覧ページ | お気に入り商品の一覧表示                                                                                       |

</details>

<details><summary>出品者用</summary>

| パス                         | ページ           | メモ                                       |
| :--------------------------- | :--------------- | :----------------------------------------- |
| /sellers/register            | 新規登録画面     | 登録後自動でログインし、店舗編集画面に遷移 |
| /sellers/login               | ログイン画面     | ログイン後ホーム画面に遷移                 |
| /sellers/home                | ホーム画面       | 店舗の経営状況を表示（stripe)              |
| /sellers/shop                | 店舗情報表示画面 |                                            |
| /sellers/editShop            | 店舗情報編集画面 |                                            |
| /sellers/item/all            | 取扱商品一覧画面 | 商品の編集画面への遷移ボタン               |
| /sellers/item/register       | 商品登録画面     |                                            |
| /sellers/item/edit/{商品 id} | 商品編集画面     | URL の id に対応した商品の編集             |
| /sellers/order               | 受注管理画面     | 受注した商品を表示（stripe）               |

</details>
