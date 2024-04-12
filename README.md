# Atte(勤怠管理システム)

## 作成した目的
人事評価

## URL
- 開発環境: 'http://localhost/'
- phpMyAdmin: 'http://localhost:8080/'

## 他のリポジトリ

## 機能一覧
- 会員登録
- ログイン
- 勤怠・休憩打刻
- 日付別勤怠管理
- ユーザー別勤怠管理
  ※勤務終了未打刻の勤怠情報は表示されない

## 使用技術(実行環境)
- PHP 8.3.0
- Laravel 8.83.27
- MYSQL 8.0.35

## テーブル設計


## ER図



## 環境構築
**Dockerビルド**
1. 'git clone git@github.com:tyswtpooh55/atte.git'
2. DockerDesktopアプリを立ち上げる
3. 'docker-compose up -d --build'

**Laravel環境構築**
1. 'docker-compose exec php bash'
2. 'composer install'
3. [.env.example]ファイルを[.env]ファイルに命名変更
4. .env　に以下の環境変数を追加

5. アプリケーションキーの作成

6. マイグレーションの実行

7. シーディングの実行
