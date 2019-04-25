CREATE OR REPLACE VIEW period_day_ein_v AS
  SELECT
    `p`.`day_key` AS `day_key`,
    `t`.`betrag`  AS `betrag`,
	`t`.`user`  AS `user`
  FROM (`haushaltsdaten2`.`transaktion` `t` LEFT JOIN `haushaltsdaten2`.`period_day` `p`
      ON (((`p`.`year_no` = year(`t`.`datum`)) AND (`p`.`month_no` = month(`t`.`datum`)) AND
           (`p`.`day_no` = dayofmonth(`t`.`datum`)))))
  WHERE (`t`.`zahlungsart` = 'Einzahlung')
  UNION SELECT
          `p`.`day_key` AS `day_key`,
          NULL          AS `NULL`,
          NULL          AS `NULL`
        FROM (`haushaltsdaten2`.`period_day` `p` LEFT JOIN `haushaltsdaten2`.`transaktion` `t`
            ON (((`p`.`year_no` = year(`t`.`datum`)) AND (`p`.`month_no` = month(`t`.`datum`)) AND
                 (`p`.`day_no` = dayofmonth(`t`.`datum`)))));
				 

SELECT day_key, SUM(betrag) FROM period_day_ein_v GROUP BY day_key