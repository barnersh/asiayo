### SQL Test

1. 請寫出一條查詢語句 (SQL)，列出在 2023 年 5 月下訂的訂單，使用台幣付款且5月總金額最 多的前 10 筆的旅宿 ID (bnb_id), 旅宿名稱 (bnb_name), 5 月總金額 (may_amount)
```mysql
SELECT
    bnbs.id AS bnb_id,
    bnbs.name AS bnb_name,
    SUM(orders.amount) AS total_amount
FROM
    orders
        JOIN
    bnbs ON orders.bnb_id = bnbs.id
WHERE
    orders.currency = 'TWD'
  AND orders.check_in_date BETWEEN '2024-08-01' AND '2024-08-31'
GROUP BY
    bnbs.id, bnbs.name
ORDER BY
    total_amount DESC
LIMIT 10;
```

2. 在題目一的執行下，我們發現 SQL 執行速度很慢，您會怎麼去優化?請闡述您怎麼判斷與優 化的方式
- Index
  - orders table
    - 新增 (check_in_date, currency) 複合索引
    - 新增 (bnb_id, bnb_name) 複合索引
- Query 修改
  - where 順序修改為
```mysql
WHERE
    orders.check_in_date BETWEEN '2024-08-01' AND '2024-08-31'
  AND orders.currency = 'TWD'
```

- 思考過程
  - currency 是屬於選擇性較少的欄位，若要充分利用 index 的效果，應該要將選擇性較多的欄位放在 index 前方
  - 為了要讓複合 index 有效果，where 順序也需要遵循 index 順序
- 其他
  - 以上是僅針對題目思考，建立多個 index 可能有利於讀取，但相對應的需要付出的空間甚至是寫入的效率，皆需要根據真實情況去做評估與取捨



### SOLID 原則和設計模式

## SOLID 原則

1. **單一職責原則 (Single Responsibility Principle)**:
    - `OrderPostRequest` 僅負責驗證訂單的輸入資料。
    - `OrderService` 僅負責處理訂單的創建邏輯。

2. **開放封閉原則 (Open/Closed Principle)**:
    - `OrderService` 通過添加新方法來擴展其功能，而無需修改現有代碼。

3. **里氏替換原則 (Liskov Substitution Principle)**:
    - `OrderFacade` 作為 `OrderService` 的入口，可以在任何地方使用 `OrderFacade` 替代 `OrderService`，而不影響其他正在使用的地方的正確性。

4. **接口隔離原則 (Interface Segregation Principle)**:
    - `CurrencyService` 和 `OrderService` 各自定義了特定的功能邏輯，控制器只需要使用需要的 Facade 入口。

5. **依賴倒置原則 (Dependency Inversion Principle)**:
    - `OrderController` 通過 `OrderFacade` 依賴於 Facade，而不是具體的 `OrderService` 實現。
    - `AppServiceProvider` 通過服務容器將 `OrderService` 注入到應用中，實現了依賴倒置。

## 設計模式

1. **Facade 模式**:
    - 使用 `OrderFacade` 簡化了 `OrderService` 的調用，使得代碼更加簡潔易讀。

2. **依賴注入 (Dependency Injection)**:
    - 通過 ServiceProvider 將 `OrderService` 註冊到服務容器，控制器通過 `OrderFacade` 進行依賴注入，解耦了組件之間的依賴關係。
