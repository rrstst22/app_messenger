# Messenger
シンプルなメッセージングアプリです。トーク相手を選択してメッセージのやり取りが可能です。<br>
ブラウザを複数開くことでユーザー間でメッセージ送受信のテストが可能です。

## :globe_with_meridians:URL
http://test

<br>
<br>

## :pencil2:本アプリについて

### 使い方
1. 「ルーム作成」ボタンから、ルーム作成
2. 作成したルーム内でメッセージのやりとり開始

![messenger](https://user-images.githubusercontent.com/92190851/141328735-802d9248-8e17-4211-ad81-e3050b366001.png)

### 機能

- メッセージ送受信
- ルーム作成、変更、削除
- ユーザー作成
- ログインユーザー変更

### 特徴

- SPA（シングルページアプリケーション）
- スマホ対応のレスポンシブなデザイン
- 簡単ログイン機能、簡単ログインユーザ変更機能搭載

<br>
<br>

## :page_facing_up:技術仕様

### 基本情報
- 言語、フレームワーク
    - HTML, CSS, JavaScript, PHP
    - Vue.js 2.6.14, Laravel 8.68.1

- 開発環境
    - Windows 10 Home
    - XAMPP(Apache, PHP, MySQL)
    - docker(Apache 2.4.51, PHP 8.0.12, Mariadb 10.6.4) ※途中からdockerへ切り替え

- デプロイ環境
    - CentOS 7
    - Apache 2.4.6, PHP 8.0.12, Mariadb 10.6.4

- テスト
    - Chromeデベロッパーツール
    - PHPUnit

### 使用技術

- 非同期通信Ajax（Vue.js）
- 親子コンポーネント間の受け渡し（Vue.js）
- データ取得、作成、削除、結合（Laravel）

### ER図

![メッセージングアプリ](https://user-images.githubusercontent.com/92190851/141139708-b391d20d-1478-4e65-9962-7d0311096252.png)
