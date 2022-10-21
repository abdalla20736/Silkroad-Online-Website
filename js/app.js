

var express = require('express');

//1.
var app = express();
var sql = require('mssql');
const config = require("./config.js");



//2.

var ouruser = "ahmed";
var PW = "5583d13d6d0f717d94a8a060b6eb4d30";
function Check(x, y) {
    if (x == ouruser && y == PW) { return true }
}
function loadAction() {
        var request = new sql.Request(config);
       
    config.connect(function (err) { 
        request.query("select StrUserID,Password from TB_USER where StrUserID = 'ahmed'").then(function (recordset) {
       
            try {
                if (Check(recordset.recordset[0].StrUserID, recordset.recordset[0].Password)) {
                    alert("Logged in")
                }
               
                
            } catch (err) {
                alert(err);
                Config.close();
            }
            config.close();
        
        });

    });
    //6.
    
}
//10.
loadAction();

app.listen(8000);
console.log("Server Is Run");