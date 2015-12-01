<?php

class m_sap extends CI_Model {
    
    function getreportMonitoring($date1, $date2){
        $query = $this->db2->query("SELECT
                T0.[CardCode], T0.[CardName],
                T0.[NumAtCard],
                T0.[DocNum],
                T0.[DocDate],
                CASE 
                WHEN T0.[DocStatus] = 'O'
                THEN 'Open'
                WHEN T0.[DocStatus] = 'C'
                THEN 'Closed'
                END AS [SOStatus],
                
                T1.[ItemCode], T1.[Dscription], 
                T1.[Quantity] , SUM(T2.[PickQtty]) AS [pkqty], SUM(T4.[Quantity]) AS [dqty] , (T1.[Quantity]-SUM(T4.[Quantity])) AS [Remaining]
                
                FROM 
                
                ORDR T0 
                INNER JOIN RDR1 T1 
                ON T0.DocEntry = T1.DocEntry
                LEFT JOIN PKL1 T2
                ON T1.DocEntry = T2.OrderEntry AND T1.[LineNum] = T2.[OrderLine]
                LEFT JOIN OPKL T3
                ON T3.AbsEntry = T2.AbsEntry
                LEFT JOIN DLN1 T4
                ON (T4.BaseEntry = T1.DocEntry AND T1.[LineNum] = T4.[BaseLine] AND T3.[AbsEntry] = T4.[PickIdNo]) 
                
                
                WHERE 
                
                (T0.[DocDate] BETWEEN '$date1' AND '$date2') AND T0.[CANCELED] = 'N'
                
                GROUP BY
                
                T0.[DocNum],
                T0.[DocDate], T0.[CardCode], T0.[CardName],
                T1.[ItemCode], T1.[Dscription], T1.[Quantity], T1.[Price],
                T0.[NumAtCard], T0.[DocStatus]");
        
        return $query->result_array();
    }
    
}

?>
