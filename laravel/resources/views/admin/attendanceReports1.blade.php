<style type="text/css">
/*    body{
    background-color:#333;
    font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    color:#333;
    text-align:left;
    font-size:18px;
    margin:0;
}
*/
/*.container{
    margin:0 auto;
    margin-top:35px;
    padding:40px;
    width:750px;
    height:auto;
    background-color:#fff;
}*/

 table {
        border-collapse: collapse;
    }   
    table, th, td {
        border: 1px solid black;
    }
    .table td, .table th {
        padding: 0.20rem !important;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }
    hr.style-one {
        border: 0;
        height: 1px;
        background: #333;
        background-image: linear-gradient(to right, #ccc, #333, #ccc);
    }
    .tables {
        width: 80%;
        max-width: 80%;
        margin-bottom: 20px;
    }

caption{
    font-size:18px;
    margin-bottom:15px;
        font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;

}   
table{
    border:1px solid #333;
    border-collapse:collapse;
    margin:0 auto;
    width: 50%;
    font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
}
td, tr, th{
    padding:12px;
    border:1px solid #333;
    width:185px;
        font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;

}
th{
/*    background-color: #f0f0f0;
*/}
h4, p{
    margin:0px;
}
</style>
<!-- 
<div class="container" style="    font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
"> -->


                        @if(!empty($purchase_orders))
                            @foreach ($purchase_orders as $poData)
                            @endforeach

    <table border="1" class="tables">
        <caption>
        Purchase Order(PO)        
</caption>
        <tbody>
            <tr style="background-color: #bbbaba">
                <th align="left" colspan="6"  style="font-weight: 500"  ><b>Party Name : </b> {{!empty($poData->partyName) ? $poData->partyName : '' }}</th>
                <th align="left"   style="font-weight: 500" ><b>PO. No : </b> #{{!empty($poData->po_no) ? $poData->po_no : '' }}</th>
                <th align="left"  style="font-weight: 500" ><b>PO. Date :  </b>{{!empty($poData->po_date) ? date("m/d/Y", strtotime($poData->po_date)) : '' }}</th>


                
                
            </tr>
            <tr>
                <th  style="background-color: #f0f0f0;"  colspan="8" >Item Detail</th>
            </tr>
            <tr style="background-color: #DDEBF7;">  
                <th align="left"  >Name</th>
                <th align="left" colspan="5" >Description</th>
                <th align="left"    >Unit</th>
                <th align="left"   >Qty.</th>
            </tr>
            
            

            <tr >  
                <td align="left">{{!empty($poData->itemNames) ? $poData->itemNames : '' }}</td>
                <td align="left" colspan="5">{{!empty($poData->description) ? $poData->description : '' }}</td>
                <td align="left">{{!empty($poData->unitName) ? $poData->unitName : '' }}</td>
                <td align="left">{{!empty($poData->qty) ? $poData->qty : '' }}</td>
            </tr>
            @if(!empty($attribute_item_name))
            <tr>
                <th  style="background-color: #f0f0f0;" colspan="8">Item Attribute Detail</th>
            </tr>
        
            <tr style="background-color: #DDEBF7;">  
                <th align="left" colspan="7" >Name</th>
                <th align="left"  >Value</th>
            </tr>

                @foreach ($attribute_item_name as $key => $values)
                    <tr>
                        <td align="left"  colspan="7" >{{!empty($attribute_item_name[$key]) ? $attribute_item_name[$key] : '' }}</td>
                        <td align="left">{{!empty($attribute_item_id_values[$key]->value) ? $attribute_item_id_values[$key]->value : '' }}</td>
                    </tr>
                @endforeach

            @endif

        </tbody>
    </table>

@endif

<!-- </div>
 -->
<?php //die;?>