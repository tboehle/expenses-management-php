CREATE OR REPLACE VIEW period_month_ein_v
AS SELECT p.month_key, t.betrag AS Betrag, t.user AS user
   FROM period_month p
     RIGHT JOIN transaktion t
       ON p.month_no = MONTH(t.datum)
          AND p.year_no = YEAR(t.datum)
  WHERE zahlungsart='Einzahlung'
  UNION
  SELECT p.month_key, NULL , Null
  FROM period_month p
    LEFT JOIN transaktion t
      ON p.month_no = MONTH(t.datum)
         AND p.year_no = YEAR(t.datum);


  SELECT month_key, SUM(betrag) FROM period_month_ein_v GROUP BY month_key
