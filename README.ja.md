# Contact Form & Dashboard

[🇬🇧 English](README.md) | 🇯🇵 Japanese

PHPとMySQLを用いて開発したお問い合わせ管理システムです。

ユーザーはフォームからお問い合わせを送信でき、管理者は管理画面からお問い合わせの閲覧・検索・管理を行えます。

HTML、CSS、JavaScript、jQuery、PHP、MySQLを用いて開発しました。

## Preview

### Public Contact Form
![Public Contact Form](assets/img/contact-form.gif)


### Administrator Login
![Administrator Login](assets/img/administration.gif)

## Background
PHPによるフォーム送信、バリデーション、データベース連携の基礎を学ぶために制作しました。

入力値の検証、データベースへの保存・取得、表示前のデータ整形など、一連のバックエンド処理を実装することを目的としました。

## Features

### お問い合わせの送信
必要事項を入力することで、お問い合わせを送信できます。

### 住所の自動入力
郵便番号を入力すると、住所を自動入力できます。

### お問い合わせ一覧の閲覧
管理者はログイン後、お問い合わせ内容を一覧で確認できます。

### お問い合わせ検索
キーワードを指定してお問い合わせを検索できます。

### お問い合わせの並び替え
新しい順・古い順に並び替えられます。

### 既読・未読ステータス
未読のお問い合わせを視覚的に区別できます。

## Tech Stack

### Frontend
- HTML
- JavaScript
- jQuery

### Backend
- PHP
- MySQL

### Libraries
- Bootstrap
- [yubinbango.js](https://github.com/yubinbango/yubinbango)

## Technology Choices
PHPのフォーム処理とデータベース連携の理解を目的としていたため、フレームワークは使用せず、PHPのみで実装しました。

スタイリングには開発効率を考慮してBootstrapを採用しました。

また、日本の住所入力に特化しており導入が容易なことから、住所自動入力ライブラリとして[yubinbango.js](https://github.com/yubinbango/yubinbango)を採用しました。

## System Design
BootstrapのSecondaryカラーをベースに、シンプルで分かりやすいUIを目指しました。

エラーメッセージや未読ステータスには赤色を使用し、ユーザーが重要な情報を見落としにくいデザインとしています。

管理画面には左固定のサイドメニューとページネーションを配置し、1ページあたり5件ずつ表示することで一覧性と操作性を両立しました。

## Implementation Highlights
データベース接続処理を共通化し、複数のファイルから再利用できる構成にしました。

接続情報は環境変数として管理し、環境ごとに設定のみ変更すれば動作するよう設計しています。

お問い合わせ入力から送信完了までのデータ保持、および管理画面のログイン状態の管理にはセッションを利用しています。

また、画面へ出力する際はエスケープ処理を行い、安全にHTMLを生成するよう実装しました。

## Challenges & Solutions
バリデーションエラー発生時やブラウザの戻る操作を行った際に、入力内容が失われてしまうことが課題でした。

この問題を解決するため、入力内容をセッションに保持し、送信完了まで同じデータを利用する仕組みを実装しました。

また、管理画面の認証も同様にセッションを利用し、ログインからログアウトまで認証状態を維持しています。

この実装を通して、セッション管理やフォーム処理の流れについて理解を深めることができました。

## Security
- パスワードは`password_hash()`を使用して安全にハッシュ化しています。
- 認証には`password_verify()`を使用しています。
- SQLインジェクション対策としてプリペアドステートメントを使用しています。
- XSS対策として、画面出力時にエスケープ処理を行っています。
- 管理画面はセッション認証によって保護しています。

## Mail Setup
ローカル開発環境では、メール送信のテストに[Mailtrap](https://mailtrap.io/)を使用しています。

### 設定手順

1. [Mailtrap](https://mailtrap.io/)のアカウントを作成します。
2. Testing Inboxを作成します。
3. `.env.example` を `.env` にコピーします。
4. MailtrapのSMTP情報を `.env` に設定します。

```
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

送信されたメールは[Mailtrap](https://mailtrap.io/)上で確認でき、実際のメールアドレスには送信されません。

## Demo Account
本プロジェクトはポートフォリオ用途のため、新規ユーザー登録機能は公開していません。

管理画面は以下のデモアカウントでログインできます。

メールアドレス：

```text
test1234@gmail.com
```

パスワード：

```text
test1234
```

既読・未読機能を確認する場合は、公開側のお問い合わせフォームから新しいお問い合わせを送信した後、管理画面へログインしてください。

新規お問い合わせを開くことで、既読・未読ステータスの変化を確認できます。

## Local Development

1. このリポジトリをクローンします。
2. `database/mails.sql` と `database/users.sql` をMySQLへインポートします。
3. `config/init.php` のデータベース設定を行います。
4. `.env.example` を `.env` にコピーします。
5. 必要な環境変数を設定します。
6. ApacheとMySQLを起動します。
7. ローカル環境からアプリケーションへアクセスします。

## Environment Variables

以下の環境変数が必要です。

```
DB_HOST=
DB_NAME=
DB_USER=
DB_PASSWORD=

MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
```

## Future Improvements

- ユーザー登録機能の追加
- PHPUnitを用いた自動テストの導入
- データベース設計のさらなる正規化
- 管理画面のレスポンシブ対応
- 実際の利用シーンやターゲットユーザーを明確にする
- 利用シーンに合わせて仕様を見直し、本番環境へデプロイする

## License & Usage
このリポジトリは、ポートフォリオとして公開しています。

ソースコードはオープンソースではなく、開発内容や技術力を紹介する目的で公開しています。

## Explore More Projects
GitHubプロフィールでは、他のプロジェクトも公開しています。

👉🏻 https://github.com/htm823