"use strict";
!function() {
    let e,o,r,s,t;
    s=(isDarkStyle?(e=config.colors_dark.cardColor,o=config.colors_dark.headingColor,r=config.colors_dark.textMuted,t=config.colors_dark.bodyColor,config.colors_dark):(e=config.colors.cardColor,o=config.colors.headingColor,r=config.colors.textMuted,t=config.colors.bodyColor,config.colors)).borderColor;
    const a= {
        series1:"#826af9",series2:"#d2b0ff",bg:"#f8d3ff"
    },
    i= {
        //series1:"#FD4600",series2:"#036D00"
        series1:"#fee802",series2:"#3fd0bd",series3:"#826bf8",series4:"#2b9bf4",series5:"#F30B0B",series6:"#154624"
    },
    l= {
        series1:"#29dac7",series2:"#60f2ca",series3:"#a5f8cd"
    };
    function n(e,o) {
        let r=0;
        for(var s=[];
        r<e;
        ) {
            var t="w"+(r+1).toString(),a=Math.floor(Math.random()*(o.max-o.min+1))+o.min;
            s.push( {
                x:t,y:a
            }),
            r++
        }
        return s
    }
    var c=document.querySelector("#lineAreaChart"),d= {
        chart: {
            height:400,type:"area",parentHeightOffset:0,toolbar: {
                show:!1
            }
        },
        dataLabels: {
            enabled:!1
        },
        stroke: {
            show:!1,curve:"straight"
        },
        legend: {
            show:!0,position:"top",horizontalAlign:"start",labels: {
                colors:t,useSeriesColors:!1
            }
        },
        grid: {
            borderColor:s,xaxis: {
                lines: {
                    show:!0
                }
            }
        },
        colors:[l.series3,l.series2,l.series1],series:[ {
            name:"Visits",data:[100,120,90,170,130,160,140,240,220,180,270,280,375]
        },
        {
            name:"Clicks",data:[60,80,70,110,80,100,90,180,160,140,200,220,275]
        },
        {
            name:"Sales",data:[20,40,30,70,40,60,50,140,120,100,140,180,220]
        }
        ],xaxis: {
            categories:["7/12","8/12","9/12","10/12","11/12","12/12","13/12","14/12","15/12","16/12","17/12","18/12","19/12","20/12"],axisBorder: {
                show:!1
            },
            axisTicks: {
                show:!1
            },
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        },
        fill: {
            opacity:1,type:"solid"
        },
        tooltip: {
            shared:!1
        }
    },
    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#barChart")),d= {
        chart: {
            height:400,type:"bar",stacked:!0,parentHeightOffset:0,toolbar: {
                show:!1
            }
        },
        plotOptions: {
            bar: {
                columnWidth:"15%",colors: {
                    backgroundBarColors:[a.bg,a.bg,a.bg,a.bg,a.bg],backgroundBarRadius:10
                }
            }
        },
        dataLabels: {
            enabled:!1
        },
        legend: {
            show:!0,position:"top",horizontalAlign:"start",labels: {
                colors:t,useSeriesColors:!1
            }
        },
        colors:[a.series1,a.series2],stroke: {
            show:!0,colors:["transparent"]
        },
        grid: {
            borderColor:s,xaxis: {
                lines: {
                    show:!0
                }
            }
        },
        series:[ {
            name:"Apple",data:[90,120,55,100,80,125,175,70,88,180]
        },
        {
            name:"Samsung",data:[85,100,30,40,95,90,30,110,62,20]
        }
        ],xaxis: {
            categories:["7/12","8/12","9/12","10/12","11/12","12/12","13/12","14/12","15/12","16/12"],axisBorder: {
                show:!1
            },
            axisTicks: {
                show:!1
            },
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        },
        fill: {
            opacity:1
        }
    },
    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#scatterChart")),d= {
        chart: {
            height:400,type:"scatter",zoom: {
                enabled:!0,type:"xy"
            },
            parentHeightOffset:0,toolbar: {
                show:!1
            }
        },
        grid: {
            borderColor:s,xaxis: {
                lines: {
                    show:!0
                }
            }
        },
        legend: {
            show:!0,position:"top",horizontalAlign:"start",labels: {
                colors:t,useSeriesColors:!1
            }
        },
        colors:[config.colors.warning,config.colors.primary,config.colors.success],series:[ {
            name:"Angular",data:[[5.4,170],[5.4,100],[5.7,110],[5.9,150],[6,200],[6.3,170],[5.7,140],[5.9,130],[7,150],[8,120],[9,170],[10,190],[11,220],[12,170],[13,230]]
        },
        {
            name:"Vue",data:[[14,220],[15,280],[16,230],[18,320],[17.5,280],[19,250],[20,350],[20.5,320],[20,320],[19,280],[17,280],[22,300],[18,120]]
        },
        {
            name:"React",data:[[14,290],[13,190],[20,220],[21,350],[21.5,290],[22,220],[23,140],[19,400],[20,200],[22,90],[20,120]]
        }
        ],xaxis: {
            tickAmount:10,axisBorder: {
                show:!1
            },
            axisTicks: {
                show:!1
            },
            labels: {
                formatter:function(e) {
                    return parseFloat(e).toFixed(1)
                },
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        }
    },
    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#lineChart")),d= {
        chart: {
            height:400,type:"line",parentHeightOffset:0,zoom: {
                enabled:!1
            },
            toolbar: {
                show:!1
            }
        },
        series:[ {
            data:[280,200,220,180,270,250,70,90,200,150,160,100,150,100,50]
        }
        ],markers: {
            strokeWidth:7,strokeOpacity:1,strokeColors:[e],colors:[config.colors.warning]
        },
        dataLabels: {
            enabled:!1
        },
        stroke: {
            curve:"straight"
        },
        colors:[config.colors.warning],grid: {
            borderColor:s,xaxis: {
                lines: {
                    show:!0
                }
            },
            padding: {
                top:-20
            }
        },
        tooltip: {
            custom:function( {
                series:e,seriesIndex:o,dataPointIndex:r
            })
            {
                return'<div class="px-3 py-2"><span>'+e[o][r]+"%</span></div>"
            }
        },
        xaxis: {
            categories:["7/12","8/12","9/12","10/12","11/12","12/12","13/12","14/12","15/12","16/12","17/12","18/12","19/12","20/12","21/12"],axisBorder: {
                show:!1
            },
            axisTicks: {
                show:!1
            },
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        }
    },


//########################################### MINISTRE ###################################################### 

    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#diagramme_annee"))
    
    var NBRE_MF = parseInt($('#NBRE_MF').val(), 10);
    var NBRE_FF = parseInt($('#NBRE_FF').val(), 10);
    var NBRE_COMM = parseInt($('#NBRE_COMM').val(), 10);
    var NBRE_ARR_ADM = parseInt($('#NBRE_ARR_ADM').val(), 10);

    var NBRE_COMM_OUVR = parseInt($('#NBRE_COMM_OUVR').val(), 10);
    var NBRE_ARR_OUVR = parseInt($('#NBRE_ARR_OUVR').val(), 10);
    var SIGNE = NBRE_MF + NBRE_FF + NBRE_COMM + NBRE_ARR_ADM + NBRE_COMM_OUVR + NBRE_ARR_OUVR;
    
    
    
    d= {
        chart: {
            height:340,type:"bar",toolbar: {
                show:!1
            }
        },
        plotOptions: {
            bar: {
                horizontal:!0,barHeight:"30%",startingShape:"rounded",borderRadius:8
            }
        },
        grid: {
            borderColor:s,xaxis: {
                lines: {
                    show:!1
                }
            },
            padding: {
                top:-20,bottom:-12
            }
        },
        colors:config.colors.info,dataLabels: {
            enabled:!1
        },
        series:[ {
            data:[NBRE_MF,NBRE_FF,NBRE_COMM,NBRE_ARR_ADM,NBRE_COMM_OUVR,NBRE_ARR_OUVR]
        }
        ],xaxis: {
            categories:["Mise en formation","Fin de formation","Communiqué","Arreté d'Admission","Communiqué d'ouverture","Arrêté d'ouverture"],axisBorder: {
                show:!1
            },
            axisTicks: {
                show:!1
            },
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        }
    },

//########################################### FIN MINISTRE ######################################################

//########################################### DGAPCE ###################################################### 

    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#diagramme_dgapce_annee"))
    
    var NBRE_PB = parseInt($('#NBRE_PB').val(), 10);
    var NBRE_RGS = parseInt($('#NBRE_RGS').val(), 10);
    var NBRE_ARSA = parseInt($('#NBRE_ARSA').val(), 10);
    var SIGNE = NBRE_PB + NBRE_RGS + NBRE_ARSA;
    
    
    
    d= {
        chart: {
            height:340,type:"bar",toolbar: {
                show:!1
            }
        },
        plotOptions: {
            bar: {
                horizontal:!0,barHeight:"30%",startingShape:"rounded",borderRadius:8
            }
        },
        grid: {
            borderColor:s,xaxis: {
                lines: {
                    show:!1
                }
            },
            padding: {
                top:-20,bottom:-12
            }
        },
        colors:config.colors.info,dataLabels: {
            enabled:!1
        },
        series:[ {
            data:[NBRE_PB,NBRE_RGS,NBRE_ARSA]
        }
        ],xaxis: {
            categories:["PRET BANCAIRE","RGS","ARSA"],axisBorder: {
                show:!1
            },
            axisTicks: {
                show:!1
            },
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        }
    },

//########################################### FIN DGAPCE ######################################################

//########################################### DAF ###################################################### 

    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#diagramme_daf_annee"))
    
    var NBRE_AP = parseInt($('#NBRE_AP').val(), 10);
    var NBRE_DP = parseInt($('#NBRE_DP').val(), 10);
    var SIGNE = NBRE_AP + NBRE_DP;
    
    
    
    d= {
        chart: {
            height:340,type:"bar",toolbar: {
                show:!1
            }
        },
        plotOptions: {
            bar: {
                horizontal:!0,barHeight:"30%",startingShape:"rounded",borderRadius:8
            }
        },
        grid: {
            borderColor:s,xaxis: {
                lines: {
                    show:!1
                }
            },
            padding: {
                top:-20,bottom:-12
            }
        },
        colors:config.colors.info,dataLabels: {
            enabled:!1
        },
        series:[ {
            data:[NBRE_AP,NBRE_DP]
        }
        ],xaxis: {
            categories:["ATTESTATION DE PRIME","DOMICILIATION DE PRIME"],axisBorder: {
                show:!1
            },
            axisTicks: {
                show:!1
            },
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        }
    },

//########################################### FIN DAF ######################################################




//########################################### CCM ###################################################### 

    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#diagramme_ccm_annee"))
    
    var NBRE_CCM_SIGNE = parseInt($('#NBRE_CCM_SIGNE').val(), 10);
    var NBRE_CCM_INSTANCE = parseInt($('#NBRE_CCM_INSTANCE').val(), 10);
    var SIGNE = NBRE_CCM_SIGNE + NBRE_CCM_INSTANCE;
    
    
    
    d= {
        chart: {
            height:340,type:"bar",toolbar: {
                show:!1
            }
        },
        plotOptions: {
            bar: {
                horizontal:!0,barHeight:"30%",startingShape:"rounded",borderRadius:8
            }
        },
        grid: {
            borderColor:s,xaxis: {
                lines: {
                    show:!1
                }
            },
            padding: {
                top:-20,bottom:-12
            }
        },
        colors:config.colors.info,dataLabels: {
            enabled:!1
        },
        series:[ {
            data:[NBRE_CCM_SIGNE,NBRE_CCM_INSTANCE]
        }
        ],xaxis: {
            categories:["DOCUMENT SIGNES","DOCUMENT EN INSTANCE"],axisBorder: {
                show:!1
            },
            axisTicks: {
                show:!1
            },
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        }
    },

//########################################### FIN CCM ######################################################

    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#horizontalBarChart")),d= {
        chart: {
            height:400,type:"bar",toolbar: {
                show:!1
            }
        },
        plotOptions: {
            bar: {
                horizontal:!0,barHeight:"30%",startingShape:"rounded",borderRadius:8
            }
        },
        grid: {
            borderColor:s,xaxis: {
                lines: {
                    show:!1
                }
            },
            padding: {
                top:-20,bottom:-12
            }
        },
        colors:config.colors.info,dataLabels: {
            enabled:!1
        },
        series:[ {
            data:[700,350,480,600,210,550,150]
        }
        ],xaxis: {
            categories:["MON, 11","THU, 14","FRI, 15","MON, 18","WED, 20","FRI, 21","MON, 23"],axisBorder: {
                show:!1
            },
            axisTicks: {
                show:!1
            },
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        }
    },
    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#candleStickChart")),d= {
        chart: {
            height:410,type:"candlestick",parentHeightOffset:0,toolbar: {
                show:!1
            }
        },
        series:[ {
            data:[ {
                x:new Date(15387786e5),y:[150,170,50,100]
            },
            {
                x:new Date(15387804e5),y:[200,400,170,330]
            },
            {
                x:new Date(15387822e5),y:[330,340,250,280]
            },
            {
                x:new Date(1538784e6),y:[300,330,200,320]
            },
            {
                x:new Date(15387858e5),y:[320,450,280,350]
            },
            {
                x:new Date(15387876e5),y:[300,350,80,250]
            },
            {
                x:new Date(15387894e5),y:[200,330,170,300]
            },
            {
                x:new Date(15387912e5),y:[200,220,70,130]
            },
            {
                x:new Date(1538793e6),y:[220,270,180,250]
            },
            {
                x:new Date(15387948e5),y:[200,250,80,100]
            },
            {
                x:new Date(15387966e5),y:[150,170,50,120]
            },
            {
                x:new Date(15387984e5),y:[110,450,10,420]
            },
            {
                x:new Date(15388002e5),y:[400,480,300,320]
            },
            {
                x:new Date(1538802e6),y:[380,480,350,450]
            }
            ]
        }
        ],xaxis: {
            type:"datetime",axisBorder: {
                show:!1
            },
            axisTicks: {
                show:!1
            },
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        },
        yaxis: {
            tooltip: {
                enabled:!0
            },
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        },
        grid: {
            borderColor:s,xaxis: {
                lines: {
                    show:!0
                }
            },
            padding: {
                top:-20
            }
        },
        plotOptions: {
            candlestick: {
                colors: {
                    upward:config.colors.success,downward:config.colors.danger
                }
            },
            bar: {
                columnWidth:"40%"
            }
        }
    },
    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#heatMapChart")),d= {
        chart: {
            height:350,type:"heatmap",parentHeightOffset:0,toolbar: {
                show:!1
            }
        },
        plotOptions: {
            heatmap: {
                enableShades:!1,colorScale: {
                    ranges:[ {
                        from:0,to:10,name:"0-10",color:"#90B3F3"
                    },
                    {
                        from:11,to:20,name:"10-20",color:"#7EA6F1"
                    },
                    {
                        from:21,to:30,name:"20-30",color:"#6B9AEF"
                    },
                    {
                        from:31,to:40,name:"30-40",color:"#598DEE"
                    },
                    {
                        from:41,to:50,name:"40-50",color:"#4680EC"
                    },
                    {
                        from:51,to:60,name:"50-60",color:"#3474EA"
                    }
                    ]
                }
            }
        },
        dataLabels: {
            enabled:!1
        },
        grid: {
            show:!1
        },
        legend: {
            show:!0,position:"top",horizontalAlign:"start",labels: {
                colors:t,useSeriesColors:!1
            },
            markers: {
                offsetY:0,offsetX:-3
            },
            itemMargin: {
                vertical:3,horizontal:10
            }
        },
        stroke: {
            curve:"smooth",width:4,lineCap:"round",colors:[e]
        },
        series:[ {
            name:"SUN",data:n(24, {
                min:0,max:60
            })
        },
        {
            name:"MON",data:n(24, {
                min:0,max:60
            })
        },
        {
            name:"TUE",data:n(24, {
                min:0,max:60
            })
        },
        {
            name:"WED",data:n(24, {
                min:0,max:60
            })
        },
        {
            name:"THU",data:n(24, {
                min:0,max:60
            })
        },
        {
            name:"FRI",data:n(24, {
                min:0,max:60
            })
        },
        {
            name:"SAT",data:n(24, {
                min:0,max:60
            })
        }
        ],xaxis: {
            labels: {
                show:!1,style: {
                    colors:r,fontSize:"13px"
                }
            },
            axisBorder: {
                show:!1
            },
            axisTicks: {
                show:!1
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors:r,fontSize:"13px"
                }
            }
        }
    },
    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#radialBarChart")),d= {
        chart: {
            height:380,type:"radialBar"
        },
        colors:[i.series1,i.series2,i.series4],plotOptions: {
            radialBar: {
                size:185,hollow: {
                    size:"40%"
                },
                track: {
                    margin:10,background:config.colors_label.secondary
                },
                dataLabels: {
                    name: {
                        fontSize:"2rem",fontFamily:"Open Sans"
                    },
                    value: {
                        fontSize:"1.2rem",color:t,fontFamily:"Open Sans"
                    },
                    total: {
                        show:!0,fontWeight:400,fontSize:"1.3rem",color:o,label:"Comments",formatter:function(e) {
                            return"80%"
                        }
                    }
                }
            }
        },
        grid: {
            borderColor:s,padding: {
                top:-25,bottom:-20
            }
        },
        legend: {
            show:!0,position:"bottom",labels: {
                colors:t,useSeriesColors:!1
            }
        },
        stroke: {
            lineCap:"round"
        },
        series:[80,50,35],labels:["Comments","Replies","Shares"]
    },
    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#radarChart")),d= {
        chart: {
            height:350,type:"radar",toolbar: {
                show:!1
            },
            dropShadow: {
                enabled:!1,blur:8,left:1,top:1,opacity:.2
            }
        },
        legend: {
            show:!0,position:"bottom",labels: {
                colors:t,useSeriesColors:!1
            }
        },
        plotOptions: {
            radar: {
                polygons: {
                    strokeColors:s,connectorColors:s
                }
            }
        },
        yaxis: {
            show:!1
        },
        series:[ {
            name:"iPhone 12",data:[41,64,81,60,42,42,33,23]
        },
        {
            name:"Samsung s20",data:[65,46,42,25,58,63,76,43]
        }
        ],colors:[i.series1,i.series3],xaxis: {
            categories:["Battery","Brand","Camera","Memory","Storage","Display","OS","Price"],labels: {
                show:!0,style: {
                    colors:[r,r,r,r,r,r,r,r],fontSize:"13px",fontFamily:"Open Sans"
                }
            }
        },
        fill: {
            opacity:[1,.8]
        },
        stroke: {
            show:!1,width:0
        },
        markers: {
            size:0
        },
        grid: {
            show:!1,padding: {
                top:-20,bottom:-20
            }
        }
    },


//########################################### MINISTRE ######################################################
    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#diagramme_signe"))
    
    var NBRE_MF = parseInt($('#NBRE_MF').val(), 10);
    var NBRE_FF = parseInt($('#NBRE_FF').val(), 10);
    var NBRE_COMM = parseInt($('#NBRE_COMM').val(), 10);
    var NBRE_ARR_ADM = parseInt($('#NBRE_ARR_ADM').val(), 10);

    var NBRE_COMM_OUVR = parseInt($('#NBRE_COMM_OUVR').val(), 10);
    var NBRE_ARR_OUVR = parseInt($('#NBRE_ARR_OUVR').val(), 10);
    var SIGNE = NBRE_MF + NBRE_FF + NBRE_COMM + NBRE_ARR_ADM + NBRE_COMM_OUVR + NBRE_ARR_OUVR;
    
    d= {
        chart: {
            height:390,type:"donut"
        },
        labels:["Mise en formation","Fin de formation","Communiqué","Arreté d'Admission","Communiqué d'ouverture","Arrêté d'ouverture"],
        series:[NBRE_MF, NBRE_FF, NBRE_COMM, NBRE_ARR_ADM, NBRE_COMM_OUVR, NBRE_ARR_OUVR],
        colors:[i.series1,i.series4,i.series3,i.series2,i.series5,i.series6],
        stroke: {
            show:!1,curve:"straight"
        },
        dataLabels: {
            enabled: true,
            formatter: function (value, { seriesIndex }) {
                const percentage = value * 100;
                const roundedValue = Math.round(percentage * 100) / 10000; // Round to 2 decimal places
                return roundedValue.toFixed(2) + "%";
            }
        },
        legend: {
            show:!0,position:"bottom",markers: {
                offsetX:-3
            },
            itemMargin: {
                vertical:3,horizontal:10
            },
            labels: {
                colors:t,useSeriesColors:!1
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show:!0,name: {
                            fontSize:"2rem",fontFamily:"Open Sans"
                        },
                        value: {
                            fontSize:"1.2rem",color:t,fontFamily:"Open Sans",formatter:function(e) {
                                return parseInt(e,10)+" Acte(s)"
                            }
                        },
                        total: {
                            show:!0,fontSize:"1.5rem",color:o,label:"Actes signés",formatter:function(e) {
                                return SIGNE
                            }
                        }
                    }
                }
            }
        },
        responsive:[ {
            breakpoint:992,options: {
                chart: {
                    height:380
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:576,options: {
                chart: {
                    height:320
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show:!0,name: {
                                    fontSize:"1.5rem"
                                },
                                value: {
                                    fontSize:"1rem"
                                },
                                total: {
                                    fontSize:"1.5rem"
                                }
                            }
                        }
                    }
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:420,options: {
                chart: {
                    height:280
                },
                legend: {
                    show:!1
                }
            }
        },
        {
            breakpoint:360,options: {
                chart: {
                    height:250
                },
                legend: {
                    show:!1
                }
            }
        }
        ]
    },
//########################################### FIN MINISTRE ######################################################




//########################################### DGAPCE ######################################################
    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#diagramme_dgapce_signe"))
    
    var NBRE_PB = parseInt($('#NBRE_PB').val(), 10);
    var NBRE_RGS = parseInt($('#NBRE_RGS').val(), 10);
    var NBRE_ARSA = parseInt($('#NBRE_ARSA').val(), 10);
    var SIGNE = NBRE_PB + NBRE_RGS + NBRE_ARSA ;
    
    d= {
        chart: {
            height:390,type:"donut"
        },
        labels:["PRET BANCAIRE","RGS","ARSA"],
        series:[NBRE_PB, NBRE_RGS, NBRE_ARSA],
        colors:[i.series1,i.series4,i.series3],
        stroke: {
            show:!1,curve:"straight"
        },
        dataLabels: {
            enabled: true,
            formatter: function (value, { seriesIndex }) {
                const percentage = value * 100;
                const roundedValue = Math.round(percentage * 100) / 10000; // Round to 2 decimal places
                return roundedValue.toFixed(2) + "%";
            }
        },
        legend: {
            show:!0,position:"bottom",markers: {
                offsetX:-3
            },
            itemMargin: {
                vertical:3,horizontal:10
            },
            labels: {
                colors:t,useSeriesColors:!1
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show:!0,name: {
                            fontSize:"2rem",fontFamily:"Open Sans"
                        },
                        value: {
                            fontSize:"1.2rem",color:t,fontFamily:"Open Sans",formatter:function(e) {
                                return parseInt(e,10)+" Acte(s)"
                            }
                        },
                        total: {
                            show:!0,fontSize:"1.5rem",color:o,label:"Actes signés",formatter:function(e) {
                                return SIGNE
                            }
                        }
                    }
                }
            }
        },
        responsive:[ {
            breakpoint:992,options: {
                chart: {
                    height:380
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:576,options: {
                chart: {
                    height:320
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show:!0,name: {
                                    fontSize:"1.5rem"
                                },
                                value: {
                                    fontSize:"1rem"
                                },
                                total: {
                                    fontSize:"1.5rem"
                                }
                            }
                        }
                    }
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:420,options: {
                chart: {
                    height:280
                },
                legend: {
                    show:!1
                }
            }
        },
        {
            breakpoint:360,options: {
                chart: {
                    height:250
                },
                legend: {
                    show:!1
                }
            }
        }
        ]
    },
//########################################### FIN DGAPCE ######################################################



//########################################### DAF ######################################################
    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#diagramme_daf_signe"))
    
    var NBRE_AP = parseInt($('#NBRE_AP').val(), 10);
    var NBRE_DP = parseInt($('#NBRE_DP').val(), 10);
    var SIGNE = NBRE_AP + NBRE_DP;
    
    d= {
        chart: {
            height:390,type:"donut"
        },
        labels:["ATTESTATION DE PRIME","DOMICILIATION DE PRIME"],
        series:[NBRE_AP, NBRE_DP],
        colors:[i.series1,i.series4],
        stroke: {
            show:!1,curve:"straight"
        },
        dataLabels: {
            enabled: true,
            formatter: function (value, { seriesIndex }) {
                const percentage = value * 100;
                const roundedValue = Math.round(percentage * 100) / 10000; // Round to 2 decimal places
                return roundedValue.toFixed(2) + "%";
            }
        },
        legend: {
            show:!0,position:"bottom",markers: {
                offsetX:-3
            },
            itemMargin: {
                vertical:3,horizontal:10
            },
            labels: {
                colors:t,useSeriesColors:!1
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show:!0,name: {
                            fontSize:"2rem",fontFamily:"Open Sans"
                        },
                        value: {
                            fontSize:"1.2rem",color:t,fontFamily:"Open Sans",formatter:function(e) {
                                return parseInt(e,10)+" Acte(s)"
                            }
                        },
                        total: {
                            show:!0,fontSize:"1.5rem",color:o,label:"Actes signés",formatter:function(e) {
                                return SIGNE
                            }
                        }
                    }
                }
            }
        },
        responsive:[ {
            breakpoint:992,options: {
                chart: {
                    height:380
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:576,options: {
                chart: {
                    height:320
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show:!0,name: {
                                    fontSize:"1.5rem"
                                },
                                value: {
                                    fontSize:"1rem"
                                },
                                total: {
                                    fontSize:"1.5rem"
                                }
                            }
                        }
                    }
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:420,options: {
                chart: {
                    height:280
                },
                legend: {
                    show:!1
                }
            }
        },
        {
            breakpoint:360,options: {
                chart: {
                    height:250
                },
                legend: {
                    show:!1
                }
            }
        }
        ]
    },
//########################################### FIN DAF ######################################################


  //########################################### MINISTRE ######################################################

    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#diagramme_instance"))
    
    var NBRE_MF = parseInt($('#NBRE_MF').val(), 10);
    var NBRE_FF = parseInt($('#NBRE_FF').val(), 10);
    var NBRE_COMM = parseInt($('#NBRE_COMM').val(), 10);
    var NBRE_ARR_ADM = parseInt($('#NBRE_ARR_ADM').val(), 10);

    var NBRE_COMM_OUVR = parseInt($('#NBRE_COMM_OUVR').val(), 10);
    var NBRE_ARR_OUVR = parseInt($('#NBRE_ARR_OUVR').val(), 10);
    var SIGNE = NBRE_MF + NBRE_FF + NBRE_COMM + NBRE_ARR_ADM + NBRE_COMM_OUVR + NBRE_ARR_OUVR;
    
    d= {
        chart: {
            height:590,type:"donut"
        },
        labels:["Mise en formation","Fin de formation","Communiqué","Arreté d'Admission","Communiqué d'ouverture des concours","Arrêté d'ouverture des concours"],
        series:[NBRE_MF, NBRE_FF, NBRE_COMM, NBRE_ARR_ADM, NBRE_COMM_OUVR, NBRE_ARR_OUVR],
        colors:[i.series1, i.series2, i.series3, i.series4, i.series5, i.series6],
        stroke: {
            show:!1,curve:"straight"
        },
        dataLabels: {
            enabled:!0,formatter:function(e,o) {
                return parseInt(e,10)+"%"
            }
        },
        legend: {
            show:!0,position:"bottom",markers: {
                offsetX:-3
            },
            itemMargin: {
                vertical:3,horizontal:10
            },
            labels: {
                colors:t,useSeriesColors:!1
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show:!0,name: {
                            fontSize:"2rem",fontFamily:"Open Sans"
                        },
                        value: {
                            fontSize:"1.2rem",color:t,fontFamily:"Open Sans",formatter:function(e) {
                                return parseInt(e,10)+" Acte(s)"
                            }
                        },
                        total: {
                            show:!0,fontSize:"1.5rem",color:o,label:"Actes en instance",formatter:function(e) {
                                return SIGNE
                            }
                        }
                    }
                }
            }
        },
        responsive:[ {
            breakpoint:992,options: {
                chart: {
                    height:380
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:576,options: {
                chart: {
                    height:320
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show:!0,name: {
                                    fontSize:"1.5rem"
                                },
                                value: {
                                    fontSize:"1rem"
                                },
                                total: {
                                    fontSize:"1.5rem"
                                }
                            }
                        }
                    }
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:420,options: {
                chart: {
                    height:280
                },
                legend: {
                    show:!1
                }
            }
        },
        {
            breakpoint:360,options: {
                chart: {
                    height:250
                },
                legend: {
                    show:!1
                }
            }
        }
        ]
    },


    //########################################### FIN MINISTRE ######################################################



     //#################################################### DGAPCE #############################################

      c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#diagramme_instance_dgapce"))
    
    var NBRE_PB = parseInt($('#NBRE_PB').val(), 10);
    var NBRE_RGS = parseInt($('#NBRE_RGS').val(), 10);
    var NBRE_ARSA = parseInt($('#NBRE_ARSA').val(), 10);
    var TOUSDGAPCE = NBRE_PB + NBRE_RGS + NBRE_ARSA;
    
    d= {
        chart: {
            height:590,type:"donut"
        },
        labels:["Prêt bancaire","RGS","ARSA"],
        series:[NBRE_PB, NBRE_RGS, NBRE_ARSA],
        colors:[i.series1,i.series4,i.series3],
        stroke: {
            show:!1,curve:"straight"
        },
        dataLabels: {
            enabled:!0,formatter:function(e,o) {
                return parseInt(e,10)+"%"
            }
        },
        legend: {
            show:!0,position:"bottom",markers: {
                offsetX:-3
            },
            itemMargin: {
                vertical:3,horizontal:10
            },
            labels: {
                colors:t,useSeriesColors:!1
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show:!0,name: {
                            fontSize:"2rem",fontFamily:"Open Sans"
                        },
                        value: {
                            fontSize:"1.2rem",color:t,fontFamily:"Open Sans",formatter:function(e) {
                                return parseInt(e,10)+" Acte(s)"
                            }
                        },
                        total: {
                            show:!0,fontSize:"1.5rem",color:o,label:"Actes en instance",formatter:function(e) {
                                return TOUSDGAPCE
                            }
                        }
                    }
                }
            }
        },
        responsive:[ {
            breakpoint:992,options: {
                chart: {
                    height:380
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:576,options: {
                chart: {
                    height:320
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show:!0,name: {
                                    fontSize:"1.5rem"
                                },
                                value: {
                                    fontSize:"1rem"
                                },
                                total: {
                                    fontSize:"1.5rem"
                                }
                            }
                        }
                    }
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:420,options: {
                chart: {
                    height:280
                },
                legend: {
                    show:!1
                }
            }
        },
        {
            breakpoint:360,options: {
                chart: {
                    height:250
                },
                legend: {
                    show:!1
                }
            }
        }
        ]
    },


      //#################################################### FIN DGAPC E#############################################




     //#################################################### DAF #############################################

      c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#diagramme_instance_daf"))
    
    var NBRE_AP = parseInt($('#NBRE_AP').val(), 10);
    var NBRE_DP = parseInt($('#NBRE_DP').val(), 10);
    var TOUSDAF = NBRE_AP + NBRE_DP ;
    
    d= {
        chart: {
            height:590,type:"donut"
        },
        labels:["Attestation de Prime","Domiciliation de Prime"],
        series:[NBRE_AP, NBRE_DP],
        colors:[i.series1,i.series4],
        stroke: {
            show:!1,curve:"straight"
        },
        dataLabels: {
            enabled:!0,formatter:function(e,o) {
                return parseInt(e,10)+"%"
            }
        },
        legend: {
            show:!0,position:"bottom",markers: {
                offsetX:-3
            },
            itemMargin: {
                vertical:3,horizontal:10
            },
            labels: {
                colors:t,useSeriesColors:!1
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show:!0,name: {
                            fontSize:"2rem",fontFamily:"Open Sans"
                        },
                        value: {
                            fontSize:"1.2rem",color:t,fontFamily:"Open Sans",formatter:function(e) {
                                return parseInt(e,10)+" Acte(s)"
                            }
                        },
                        total: {
                            show:!0,fontSize:"1.5rem",color:o,label:"Actes en instance",formatter:function(e) {
                                return TOUSDAF
                            }
                        }
                    }
                }
            }
        },
        responsive:[ {
            breakpoint:992,options: {
                chart: {
                    height:380
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:576,options: {
                chart: {
                    height:320
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show:!0,name: {
                                    fontSize:"1.5rem"
                                },
                                value: {
                                    fontSize:"1rem"
                                },
                                total: {
                                    fontSize:"1.5rem"
                                }
                            }
                        }
                    }
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:420,options: {
                chart: {
                    height:280
                },
                legend: {
                    show:!1
                }
            }
        },
        {
            breakpoint:360,options: {
                chart: {
                    height:250
                },
                legend: {
                    show:!1
                }
            }
        }
        ]
    },


      //#################################################### FIN DAF E#############################################



    //#################################################### CCM #############################################

      c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#diagramme_instance_ccm"))
    
    var NBRE_CCM_INSTANCE = parseInt($('#NBRE_CCM_INSTANCE').val(), 10);
    var NBRE_CCM_SIGNE = parseInt($('#NBRE_CCM_SIGNE').val(), 10);
    var TOUSCCM = NBRE_CCM_INSTANCE + NBRE_CCM_SIGNE ;
    
    d= {
        chart: {
            height:590,type:"donut"
        },
        labels:["Documents en instance","Documents signés"],
        series:[NBRE_CCM_INSTANCE, NBRE_CCM_SIGNE],
        colors:[i.series1,i.series4],
        stroke: {
            show:!1,curve:"straight"
        },
        dataLabels: {
            enabled:!0,formatter:function(e,o) {
                return parseInt(e,10)+"%"
            }
        },
        legend: {
            show:!0,position:"bottom",markers: {
                offsetX:-3
            },
            itemMargin: {
                vertical:3,horizontal:10
            },
            labels: {
                colors:t,useSeriesColors:!1
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show:!0,name: {
                            fontSize:"2rem",fontFamily:"Open Sans"
                        },
                        value: {
                            fontSize:"1.2rem",color:t,fontFamily:"Open Sans",formatter:function(e) {
                                return parseInt(e,10)+" Acte(s)"
                            }
                        },
                        total: {
                            show:!0,fontSize:"1.5rem",color:o,label:"Documents a disposition",formatter:function(e) {
                                return TOUSCCM
                            }
                        }
                    }
                }
            }
        },
        responsive:[ {
            breakpoint:992,options: {
                chart: {
                    height:380
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:576,options: {
                chart: {
                    height:320
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show:!0,name: {
                                    fontSize:"1.5rem"
                                },
                                value: {
                                    fontSize:"1rem"
                                },
                                total: {
                                    fontSize:"1.5rem"
                                }
                            }
                        }
                    }
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:420,options: {
                chart: {
                    height:280
                },
                legend: {
                    show:!1
                }
            }
        },
        {
            breakpoint:360,options: {
                chart: {
                    height:250
                },
                legend: {
                    show:!1
                }
            }
        }
        ]
    },


      //#################################################### FIN CCM E#############################################


    c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#donutChart")),d= {
        chart: {
            height:390,type:"donut"
        },
        labels:["Actes signés","En instance"],series:[75,25],colors:[i.series1,i.series4],stroke: {
            show:!1,curve:"straight"
        },
        dataLabels: {
            enabled:!0,formatter:function(e,o) {
                return parseInt(e,10)+"%"
            }
        },
        legend: {
            show:!0,position:"bottom",markers: {
                offsetX:-3
            },
            itemMargin: {
                vertical:3,horizontal:10
            },
            labels: {
                colors:t,useSeriesColors:!1
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show:!0,name: {
                            fontSize:"2rem",fontFamily:"Open Sans"
                        },
                        value: {
                            fontSize:"1.2rem",color:t,fontFamily:"Open Sans",formatter:function(e) {
                                return parseInt(e,10)+"%"
                            }
                        },
                        total: {
                            show:!0,fontSize:"1.5rem",color:o,label:"Actes signés",formatter:function(e) {
                                return"75%"
                            }
                        }
                    }
                }
            }
        },
        responsive:[ {
            breakpoint:992,options: {
                chart: {
                    height:380
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:576,options: {
                chart: {
                    height:320
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show:!0,name: {
                                    fontSize:"1.5rem"
                                },
                                value: {
                                    fontSize:"1rem"
                                },
                                total: {
                                    fontSize:"1.5rem"
                                }
                            }
                        }
                    }
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:420,options: {
                chart: {
                    height:280
                },
                legend: {
                    show:!1
                }
            }
        },
        {
            breakpoint:360,options: {
                chart: {
                    height:250
                },
                legend: {
                    show:!1
                }
            }
        }
        ]
    },
	c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#donutChart2")),d= {
        chart: {
            height:390,type:"donut"
        },
        labels:["Actes signés","En instance"],series:[75,25],colors:[i.series4,i.series3],stroke: {
            show:!1,curve:"straight"
        },
        dataLabels: {
            enabled:!0,formatter:function(e,o) {
                return parseInt(e,10)+"%"
            }
        },
        legend: {
            show:!0,position:"bottom",markers: {
                offsetX:-3
            },
            itemMargin: {
                vertical:3,horizontal:10
            },
            labels: {
                colors:t,useSeriesColors:!1
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show:!0,name: {
                            fontSize:"2rem",fontFamily:"Open Sans"
                        },
                        value: {
                            fontSize:"1.2rem",color:t,fontFamily:"Open Sans",formatter:function(e) {
                                return parseInt(e,10)+"%"
                            }
                        },
                        total: {
                            show:!0,fontSize:"1.5rem",color:o,label:"Actes signés",formatter:function(e) {
                                return"75%"
                            }
                        }
                    }
                }
            }
        },
        responsive:[ {
            breakpoint:992,options: {
                chart: {
                    height:380
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:576,options: {
                chart: {
                    height:320
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show:!0,name: {
                                    fontSize:"1.5rem"
                                },
                                value: {
                                    fontSize:"1rem"
                                },
                                total: {
                                    fontSize:"1.5rem"
                                }
                            }
                        }
                    }
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:420,options: {
                chart: {
                    height:280
                },
                legend: {
                    show:!1
                }
            }
        },
        {
            breakpoint:360,options: {
                chart: {
                    height:250
                },
                legend: {
                    show:!1
                }
            }
        }
        ]
    },
	c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#donutChart3")),d= {
        chart: {
            height:390,type:"donut"
        },
        labels:["Actes signés","En instance"],series:[75,25],colors:[i.series3,i.series2],stroke: {
            show:!1,curve:"straight"
        },
        dataLabels: {
            enabled:!0,formatter:function(e,o) {
                return parseInt(e,10)+"%"
            }
        },
        legend: {
            show:!0,position:"bottom",markers: {
                offsetX:-3
            },
            itemMargin: {
                vertical:3,horizontal:10
            },
            labels: {
                colors:t,useSeriesColors:!1
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show:!0,name: {
                            fontSize:"2rem",fontFamily:"Open Sans"
                        },
                        value: {
                            fontSize:"1.2rem",color:t,fontFamily:"Open Sans",formatter:function(e) {
                                return parseInt(e,10)+"%"
                            }
                        },
                        total: {
                            show:!0,fontSize:"1.5rem",color:o,label:"Actes signés",formatter:function(e) {
                                return"75%"
                            }
                        }
                    }
                }
            }
        },
        responsive:[ {
            breakpoint:992,options: {
                chart: {
                    height:380
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:576,options: {
                chart: {
                    height:320
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show:!0,name: {
                                    fontSize:"1.5rem"
                                },
                                value: {
                                    fontSize:"1rem"
                                },
                                total: {
                                    fontSize:"1.5rem"
                                }
                            }
                        }
                    }
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:420,options: {
                chart: {
                    height:280
                },
                legend: {
                    show:!1
                }
            }
        },
        {
            breakpoint:360,options: {
                chart: {
                    height:250
                },
                legend: {
                    show:!1
                }
            }
        }
        ]
    },
	c=(null!==c&&new ApexCharts(c,d).render(),document.querySelector("#donutChart4")),d= {
        chart: {
            height:390,type:"donut"
        },
        labels:["Actes signés","En instance"],series:[75,25],colors:[i.series1,i.series2],stroke: {
            show:!1,curve:"straight"
        },
        dataLabels: {
            enabled:!0,formatter:function(e,o) {
                return parseInt(e,10)+"%"
            }
        },
        legend: {
            show:!0,position:"bottom",markers: {
                offsetX:-3
            },
            itemMargin: {
                vertical:3,horizontal:10
            },
            labels: {
                colors:t,useSeriesColors:!1
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show:!0,name: {
                            fontSize:"2rem",fontFamily:"Open Sans"
                        },
                        value: {
                            fontSize:"1.2rem",color:t,fontFamily:"Open Sans",formatter:function(e) {
                                return parseInt(e,10)+"%"
                            }
                        },
                        total: {
                            show:!0,fontSize:"1.5rem",color:o,label:"Actes signés",formatter:function(e) {
                                return"75%"
                            }
                        }
                    }
                }
            }
        },
        responsive:[ {
            breakpoint:992,options: {
                chart: {
                    height:380
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:576,options: {
                chart: {
                    height:320
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show:!0,name: {
                                    fontSize:"1.5rem"
                                },
                                value: {
                                    fontSize:"1rem"
                                },
                                total: {
                                    fontSize:"1.5rem"
                                }
                            }
                        }
                    }
                },
                legend: {
                    position:"bottom",labels: {
                        colors:t,useSeriesColors:!1
                    }
                }
            }
        },
        {
            breakpoint:420,options: {
                chart: {
                    height:280
                },
                legend: {
                    show:!1
                }
            }
        },
        {
            breakpoint:360,options: {
                chart: {
                    height:250
                },
                legend: {
                    show:!1
                }
            }
        }
        ]
    };



    








    null!==c&&new ApexCharts(c,d).render()
}
();
