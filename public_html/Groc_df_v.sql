SELECT
  `train_sample1`.`id` AS `ts_id`,
  `train_sample1`.`date` AS `ts_date`,
  `train_sample1`.`store_nbr` AS `ts_store_nbr`,
  `train_sample1`.`item_nbr` AS `ts_item_nbr`,
  `train_sample1`.`unit_sales` AS `ts_unit_sales`,
  `train_sample1`.`onpromotion` AS `ts_onpromotion`,
  `items`.`family` AS `i_family`,
  `items`.`class` AS `i_class`,
  `items`.`perishable` AS `i_perishable`,
  `stores`.`city` AS `s_city`,
  `stores`.`state` AS `s_state`,
  `stores`.`type` AS `s_type`,
  `stores`.`cluster` AS `s_cluster`,
  `oil`.`dcoilwtico` AS `o_dcoilwtico`,
  `transactions`.`transactions` AS `t_transactions`,
   CASE WHEN h1.description IS NOT NULL THEN 1 ELSE 0 END AS h_is_holiday,
   h1.type AS h_type,
   h1.locale AS h_locale,
   h1.locale_name AS h_locale_name,
   h1.description AS h_description,
   h1.transferred AS h_transferred
FROM
  `train_sample1` JOIN `items` ON`items`.`item_nbr` = `train_sample1`.`item_nbr`
  JOIN `stores` ON `stores`.`store_nbr` = `train_sample1`.`store_nbr`
  LEFT JOIN `oil` ON `oil`.`date` = `train_sample1`.`date`
  LEFT JOIN `transactions` ON `transactions`.`date` = `train_sample1`.`date` AND `transactions`.`store_nbr` = `train_sample1`.`store_nbr`
  LEFT JOIN holidays_events AS h1 ON h1.date = train_sample1.date
  LEFT JOIN holidays_events AS h2 ON h2.date = train_sample1.date AND h1.description > h2.description
WHERE
  h2.date IS NULL

