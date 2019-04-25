CREATE OR REPLACE VIEW period_year_aus_v AS
  SELECT
    `p`.`year`   AS `year`,
    `t`.`betrag` AS `Betrag`,
    `t`.`user` AS `user`
  FROM (`haushaltsdaten2`.`transaktion` `t` LEFT JOIN `haushaltsdaten2`.`period_year` `p`
      ON ((`p`.`year` = year(`t`.`datum`))))
  WHERE (`t`.`zahlungsart` = 'Auszahlung')
  UNION SELECT
          `p`.`year` AS `year`,
          NULL       AS `NULL`,
          NULL       AS `NULL`
        FROM (`haushaltsdaten2`.`period_year` `p` LEFT JOIN `haushaltsdaten2`.`transaktion` `t`
            ON ((`p`.`year` = year(`t`.`datum`))));

			
			
SELECT year, SUM(betrag) FROM period_year_aus_v GROUP BY year;