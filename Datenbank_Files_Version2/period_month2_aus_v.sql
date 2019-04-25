CREATE OR REPLACE VIEW period_month_aus_v AS
  SELECT
    `p`.`month_key` AS `month_key`,
    `t`.`betrag`    AS `Betrag`,
    `t`.`user`    AS `user`
  FROM (`haushaltsdaten2`.`transaktion` `t` LEFT JOIN `haushaltsdaten2`.`period_month` `p`
      ON (((`p`.`month_no` = month(`t`.`datum`)) AND (`p`.`year_no` = year(`t`.`datum`)))))
  WHERE (`t`.`zahlungsart` = 'Auszahlung')
  UNION SELECT
          `p`.`month_key` AS `month_key`,
          NULL            AS `NULL`,
          NULL            AS `NULL`
        FROM (`haushaltsdaten2`.`period_month` `p` LEFT JOIN `haushaltsdaten2`.`transaktion` `t`
            ON (((`p`.`month_no` = month(`t`.`datum`)) AND (`p`.`year_no` = year(`t`.`datum`)))));



  SELECT month_key, SUM(betrag) FROM period_month_aus_v GROUP BY month_key