現在製作の途中です。

# 環境構築手順

1. **リポジトリをクローン**
```
git clone https://github.com/Fukushinaharuto/SiteForestBack.git
```
2. **Dockerイメージをビルド**
```
docker compose build
```
3. **バックエンドコンテナに入る**
```
docker compose run back /bin/bash
```
4. **依存関係をインストール**
- コンテナ内で下記のコマンドを実行します。
```
composer install
```
- 上記のコードを実行後、コンテナを出ます。
5. **コンテナを起動**
```
docker compose up -d
```

# **構成・概要**
### プロジェクト名
SiteForest

### プロジェクトの目的
プログラミング未経験の方でも、コードを書かずにサイトを作成できるようになる。

### 技術スタック
| 言語・フレームワーク・その他 | バージョン |
| -------------------- | ---------- |
| PHP                  | 8.3.12     |
| Laravel              | 11.41.3    |
| PostgreSQL           | 14.13      |
| Docker               | 27.4.0     |
| git	                 | 2.45.2     |


### 使用したファイル概要とディレクトリ構成
```
/
 ├── back/
 │   ├── app/Http
 │   │   │   ├──/Controllers
 │   │   │   │   ├──/AuthController.php           #認証機能
 │   │   │   │   ├──/PageComponentController.php  #ページのドラッグ要素の保存
 │   │   │   │   ├──/PageController.php           #ページの作成など 
 │   │   │   │   └──/ProjectController.php        #プロジェクトの作成や削除編集など
 │   │   │   │ 
 │   │   │   └──/Requests                         #バリデーション
 │   │   │        ├──/LoginRequest.php             
 │   │   │        ├──/PageRequest.php             
 │   │   │        ├──/ProjectRequest.php           
 │   │   │        └──/RegisterRequest.php          
 │   │   │
 │   │   └──/Models                               #リレーション
 │   │       ├──/HyperLink.php                    
 │   │       ├──/Page.php                    
 │   │       ├──/PageComponent.php                   
 │   │       ├──/Project.php                     
 │   │       ├──/Square.php                 
 │   │       ├──/Text.php
 │   │       └──/User.php                     
 │   │      
 │   └── routes/api.php                           #APIのルーティングが記載されている
 │   
 │ 
 ├── docker-compose.yml                           #dockerコンテナの設定が記載されている。
 └── dockerfile                                   #dockerイメージの設定が記載されている。
```

### 今後作成すること
- 要素の削除
- 保存したページの要素の表示(データベースから取り出して)
- cookiesの有効期限が切れたらTokenを削除する
- ログアウト機能
- 要素の重なりの順番入れ替え
- 色々な要素の追加、例写真など



