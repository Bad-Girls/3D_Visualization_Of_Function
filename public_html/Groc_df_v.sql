SELECT
  `train_sample1`.`id` AS `ts_id`,
  `train_sample1`.`date` AS `ts_date`,
  `train_sample1`.`store_nbr` AS `ts_store_nbr`,
  `train_sample1`.`item_nbr` AS `ts_item_nbr`,
  `train_sample1`.`unit_sales` AS `ts_unit_sales`,
  `train_sample1`.`onpromotion` AS `ts_onpromotion`,
  `items`.`family` AS `i_family`,
 