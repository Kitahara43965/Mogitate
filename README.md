## アプリケーション名

Mogitate

## 環境構築

(イ) ローカルリポジトリの設定<br>
ローカルリポジトリを作成するディレクトリにおいてコマンドライン上で<br>
$ `git clone git@github.com:Kitahara43965/Mogitate.git`<br>
$ mv Mogitate (ローカルリポジトリ名)<br>
とすればリモートリポジトリのクローンが生成され、所望のローカルリポジトリ名のディレクトリが得られます。<br>
<br>
(ロ) docker の設定<br>
$ cd (ローカルリポジトリ名)<br>
docker が起動していることを確認した上で<br>
$ docker-compose up -d --build<br>
とします。<br>
$ cd docker/php<br>
$ docker-compose exec php bash<br>
で php コンテナ内に入り、<br>
$ composer install<br>
で composer をインストールします。<br>
<br>
(ハ) web アプリの立ち上げ<br>
(ハ-1) php コンテナ上で<br>
$ cp .env.example .env<br>
と入力し、.env ファイルを複製します。<br>
(ハ-2) .env ファイルで<br>
APP_LOCALE=ja {APP_NAMEの上に追加}<br>
DB_HOST=mysql<br>
DB_PORT=3306<br>
DB_DATABASE=laravel_db<br>
DB_USERNAME=laravel_user<br>
DB_PASSWORD=laravel_pass<br>
とします。<br>
(ハ-3) php コンテナ上で<br>
$ php artisan key:generate<br>
$ php artisan migrate:fresh {もしくは $ php artisan migrate}<br>
$ php artisan db:seed<br>
と入力します。<br>
さらに、
rm public/storage {既存のリンクを削除}<br>
php artisan storage:link {再度リンクの作成}<br>
をすることで web アプリが起動します。<br>
<br>

## 使用技術(実行環境)<br>

Laravel 8.83.8<br>
<br>

## ER 図<br>

<img width="841" height="241" alt="Image" src="https://github.com/user-attachments/assets/6c7da902-3d2b-411e-a16f-ba5c3bb8f2ef" /><br>
<br>

## URL<br>

- 例) 開発環境：http://localhost/<br>

