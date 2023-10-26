# 自己紹介Webサービス LINKARD

<img src="./public/favicon.png" alt="プロジェクトのロゴ" width="100" height="100">

## 概要

LINKARDはモバイル対応の自己紹介Webサービスです。フロントエンドには、React(Vite)を使用し、バックエンドにはLaravel（API）を使用、DBはMySQLを用いています。

## デプロイメント

本プロジェクトのバックエンドはさくらのレンタルサーバーにデプロイしています。デプロイにはGitHub Actionsを活用しています。mainブランチに新たなコードがpushされると、自動的に本番サーバーにその変更が反映されます。

## 特徴

- Laravel sanctumを用いたapiトークン認証方式
- CRUD機能

## 使用技術

- React Vite (front)
- Laravel (backend)
- MySQL