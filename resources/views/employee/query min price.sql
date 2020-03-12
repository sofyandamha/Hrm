
SELECT *, tem.`sumber_id` FROM `transactions` AS tem JOIN
(
SELECT trx.`item_id`, trx.`price` , COUNT(1) AS trxtot FROM `transactions` AS trx JOIN
(SELECT `item_id`, MIN(`price`) AS MInPRICE, COUNT(1) AS TOTAL
	FROM
		`transactions`
WHERE IFNULL(price, 0) > 0
GROUP BY item_id) AS cte  ON trx.`item_id` = cte.item_id AND trx.`price` = cte.minprice -- AND trx.`item_id` = 10008
GROUP BY trx.`item_id` , trx.`price`
HAVING COUNT(trxtot) = 1 ) AS yxz ON tem.`item_id` = yxz.item_id AND tem.`price` = yxz.price;
-- union

SELECT trx1.`item_id`, trx1.`price`, MIN(us.`is_priority`) FROM `transactions` AS trx1 JOIN
(
	SELECT trx.`item_id`, trx.`price`, COUNT(1) AS trxtot FROM `transactions` AS trx JOIN
	(
	SELECT `item_id`, MIN(`price`) AS MInPRICE, COUNT(1) AS TOTAL
		FROM
			`transactions`
	WHERE IFNULL(price, 0) > 0
	GROUP BY item_id) AS cte  ON trx.`item_id` = cte.item_id AND trx.`price` = cte.minprice
	GROUP BY trx.`item_id` , trx.`price`
	HAVING COUNT(trxtot) > 1) AS btx ON `trx1`.`item_id` =btx.item_id  AND `trx1`.`price` = btx.price
	JOIN `users` AS us ON us.`id` = trx1.`vendor_id` WHERE us.area_id =1 AND trx1.`sumber_id`  = 1
	GROUP BY trx1.`item_id` , trx1.`price` ;
