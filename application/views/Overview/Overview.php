    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
	google.charts.load('current', {'packages':['line']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            RenderReportByMonth();
        }
	
	function dynamicLoad(content)
	{
            console.log(content);
            var data = new google.visualization.DataTable();
            $.each(content.columns,function(key,value){
                data.addColumn(value[0],value[1]);
            });

            data.addRows(content.content);

            var options = {
              chart: {
                title: content.title,
                subtitle: content.subTitle
              },
              width: 900,
              height: 500
            };

            var chart = new google.charts.Line(document.getElementById('chart_div'));

            chart.draw(data, google.charts.Line.convertOptions(options));
            
            $("#sortModal").modal('hide');
	}
    </script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();   
            $("#sort-icon").click(function(){
               $("#sortModal").modal(); 
            });
            
            var current_month = parseInt("<?php echo $current_month; ?>");
            $(".day-holder").fadeOut();
            $(".week-holder").fadeOut();
            $(".month-holder").fadeIn();
            $(".year-holder").fadeIn();
            $("#month_selector").val(current_month);
            //sorting
                $("#sort_selector").change(function(){
                    var sorter = $(this).val();
                    if(sorter == 1)
                    {
                        $(".week-holder").fadeIn();
                        $(".month-holder").fadeOut();
                        $(".year-holder").fadeOut();
                    }
                    else if(sorter == 2)
                    {
                        $(".week-holder").fadeOut();
                        $(".month-holder").fadeIn();
                        $(".year-holder").fadeIn();
                    }
                    else if(sorter == 3)
                    {
                        $(".week-holder").fadeOut();
                        $(".month-holder").fadeOut();
                        $(".year-holder").fadeIn();
                    }
                });

                $("#show_results").click(function(){
                    var sorter = $("#sort_selector").val();
                    if(sorter == 1)
                    {
                        //week
                        RenderReportByWeek();
                    }
                    else if(sorter == 2)
                    {
                        //month
                        RenderReportByMonth();
                    }
                    else if(sorter == 3)
                    {
                        //year
                        RenderReportByYear();
                    }
                });
        });
        
            
            var RenderReportByMonth = function()
            {
                $.ajax({
                    url : '/admin/GetReportByMonth',
                    method : 'POST',
                    data : {
                        month : $("#month_selector").val(),
                        year : $("#year_selector").val()
                    },
                    dataType : "json",
                    beforeSend : function(){
                    },
                    success : function(data){
                        if(data.success)
                        {
                            dynamicLoad(data);
                        }
                        else
                        {
                            alert("Error connecting to server.");
                        }
                    },
                    error : function(){
                        alert("Error connecting to server.");
                    }
                });
            };

            var RenderReportByYear = function()
            {
                $.ajax({
                    url : '/admin/GetReportByYear',
                    method : 'POST',
                    data : {
                        year : $("#year_selector").val()
                    },
                    dataType : "json",
                    beforeSend : function(){
                    },
                    success : function(data){
                        if(data.success)
                        {
                            var valid_pie = false;
                            $.each(data.content,function(key,value){
                                var int_value = parseInt(value['value']);
                                data.content[key]['value'] = int_value;
                                if(int_value > 0)
                                {
                                    valid_pie = true;
                                }
                            });

                            if(valid_pie)
                            {
                                $("#tabular-view").fadeIn();
                                $(".no-data-found").css("display","none");
                                $("#myPie").fadeIn();
                                if(pie == null)
                                {
                                    window.pie = new d3pie("myPie", {
                                            header: {
                                            },
                                            data: {
                                                    content: data.content
                                            }
                                    });
                                }
                                else
                                {
                                    pie.updateProp("data.content", data.content);
                                }
                                
                                RenderTabularView(data.content);
                            }
                            else
                            {
                               $(".no-data-found").css("display","block");
                               $("#myPie").fadeOut();
                               $("#tabular-view").fadeOut();
                            }
                        }
                        else
                        {
                            alert("Error connecting to server.");
                        }
                    },
                    error : function(){
                        alert("Error connecting to server.");
                    }
                });
            };

            var RenderReportByWeek = function()
            {
                $.ajax({
                    url : '/admin/GetReportByWeek',
                    method : 'POST',
                    data : {
                        week : $("#week_selector").val()
                    },
                    dataType : "json",
                    beforeSend : function(){
                    },
                    success : function(data){
                        if(data.success)
                        {
                            var valid_pie = false;
                            $.each(data.content,function(key,value){
                                var int_value = parseInt(value['value']);
                                data.content[key]['value'] = int_value;
                                if(int_value > 0)
                                {
                                    valid_pie = true;
                                }
                            });

                            if(valid_pie)
                            {
                                $("#tabular-view").fadeIn();
                                $(".no-data-found").css("display","none");
                                $("#myPie").fadeIn();
                                if(pie == null)
                                {
                                    window.pie = new d3pie("myPie", {
                                            header: {
                                            },
                                            data: {
                                                    content: data.content
                                            }
                                    });
                                }
                                else
                                {
                                    pie.updateProp("data.content", data.content);
                                }
                            }
                            else
                            {
                               $(".no-data-found").css("display","block");
                               $("#myPie").fadeOut();
                            }
                        }
                        else
                        {
                            alert("Error connecting to server.");
                        }
                    },
                    error : function(){
                        alert("Error connecting to server.");
                    }
                });
            };
    </script>
    <div class="col-xs-10">
        <div class="container">
            <div class="main-container col-xs-12">
                <div id="chart_div">
                    <img id="chart-loader" src="/images/oval.svg">
                </div>
            </div>
        </div>
    </div>
    <div id="sortModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Report View Option:</h4>
                </div>
                <div class="modal-body">
                    <div class="row report-inputs">
                        <div class="form-group-sm col-xs-12">
                            <label>Show Reports By</label>
                            <select class="form-control" id="sort_selector">
                                <option value="1">Week</option>
                                <option value="2" selected>Month</option>
                                <option value="3">Year</option>
                            </select>
                        </div>
                        <div class="form-group-sm col-xs-12 month-holder">
                            <label>Month</label>
                            <select class="form-control" id="month_selector">
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="form-group-sm col-xs-12 year-holder">
                            <label>Year</label>
                            <select class="form-control" id="year_selector">
                                <?php echo $years; ?>
                            </select>
                        </div>
                        <div class="form-group-sm col-xs-12 day-holder">
                            <label>Day</label>
                            <input type="date" class="form-control" id="day_selector">
                        </div>
                        <div class="form-group-sm col-xs-12 week-holder">
                            <label>Week</label>
                            <input type="week" class="form-control" id="week_selector">
                        </div>
                        <div class="form-group-sm col-xs-12">
                            <button type="button" class="btn pull-right" id="show_results">SHOW REPORT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <img data-toggle="popover" data-placement="top" data-trigger="hover" data-content="Sort Options" id="sort-icon" src="/images/sort.svg">