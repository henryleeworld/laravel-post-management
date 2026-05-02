# Laravel 13 文章管理

你隨時可以撰寫、編輯或刪除文章。

## 使用方式
- 把整個專案複製一份到你的電腦裡，這裡指的「內容」不是只有檔案，而是指所有整個專案的歷史紀錄、分支、標籤等內容都會複製一份下來。
```sh
$ git clone
```
- 將 __.env.example__ 檔案重新命名成 __.env__，如果應用程式金鑰沒有被設定的話，你的使用者 sessions 和其他加密的資料都是不安全的！
- 當你的專案中已經有 composer.lock，可以直接執行指令以讓 Composer 安裝 composer.lock 中指定的套件及版本。
```sh
$ composer install
```
- 產生 Laravel 要使用的一組 32 字元長度的隨機字串 APP_KEY 並存在 .env 內。
```sh
$ php artisan key:generate
```
- 執行 __Artisan__ 指令的 __migrate__ 來執行所有未完成的遷移，並執行資料庫填充（如果要測試的話）。
```sh
$ php artisan migrate --seed
```
- 執行安裝 Vite 和 Laravel 擴充套件引用的依賴項目。
```sh
$ npm install
```
- 執行正式環境版本化資源管道並編譯。
```sh
$ npm run build
```
- 運行單元測試和功能測試。大多數的單元測試可能只專注於單一個方法，功能測試則可以測試大部分的程式碼，包含一些物件如何進行互動，甚至是完整的 HTTP 請求到一個 JSON 端點。
```sh
$ php artisan test
```
- 在瀏覽器中輸入已定義的路由 URL 來訪問，例如：http://127.0.0.1:8000。
- 你可以經由 `/login` 來進行登入，預設的電子郵件和密碼分別為 __admin@admin.com__ 和 __password__ 。
- 登入後可以經由 `/posts` 來進行文章管理。

----

## 畫面截圖
![](https://i.imgur.com/olMNMOo.png)
> 檢查程式碼是否如預期般執行

![](https://i.imgur.com/HHY7O9M.png)
> 如果不知道或是不確定如何訂標題，不如先空置在那邊，先處理內容，想想要提供什麼樣的資訊給讀者或是客戶，才是撰寫的目的，等到內容完成後，讓自己以及他人閱讀過後，就能夠提供不同的意見，給予適當的標題建議

![](https://i.imgur.com/6JzcCzH.png)
> 網址代稱的命名與網域名稱一樣，都需要經過命名的思考，如果建立文章時未提供則會使用標題產生
