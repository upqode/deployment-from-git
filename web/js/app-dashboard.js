var App = (function () {
  'use strict';
  
  App.dashboard = function() {

    //Counter
    function counter() {
      $('[data-toggle="counter"]').each(function(i, e){
        var _el       = $(this);
        var prefix    = '';
        var suffix    = '';
        var start     = 0;
        var end       = 0;
        var decimals  = 0;
        var duration  = 2.5;

        if( _el.data('prefix') ){ prefix = _el.data('prefix'); }

        if( _el.data('suffix') ){ suffix = _el.data('suffix'); }

        if( _el.data('start') ){ start = _el.data('start'); }

        if( _el.data('end') ){ end = _el.data('end'); }

        if( _el.data('decimals') ){ decimals = _el.data('decimals'); }

        if( _el.data('duration') ){ duration = _el.data('duration'); }

        var count = new CountUp(_el.get(0), start, end, decimals, duration, { 
          suffix: suffix,
          prefix: prefix
        });

        count.start();
      });
    }

    //Top tile widgets
    function sparklines() {
      var color1 = App.color.primary;
      var color2 = App.color.warning;
      var color3 = App.color.success;
      var color4 = App.color.danger;

      $('#spark1').sparkline([0,5,3,7,5,10,3,6,5,10], { 
        width: '85',
        height: '35',
        lineColor: color1,
        highlightSpotColor: color1,
        highlightLineColor: color1,
        fillColor: false,
        spotColor: false,
        minSpotColor: false,
        maxSpotColor: false,
        lineWidth: 1.15
      });

      $("#spark2").sparkline([5,8,7,10,9,10,8,6,4,6,8,7,6,8], { 
        type: 'bar', 
        width: '85',
        height: '35',
        barWidth: 3,
        barSpacing: 3,
        chartRangeMin: 0,
        barColor: color2 
      });

      $('#spark3').sparkline([2,3,4,5,4,3,2,3,4,5,6,5,4,3,4,5,6,5,4,4,5], { 
        type: 'discrete', 
        width: '85',
        height: '35',
        lineHeight: 20,
        lineColor: color3,
        xwidth: 18 
      });

      $('#spark4').sparkline([2,5,3,7,5,10,3,6,5,7], { 
        width: '85',
        height: '35',
        lineColor: color4,
        highlightSpotColor: color4,
        highlightLineColor: color4,
        fillColor: false,
        spotColor: false,
        minSpotColor: false,
        maxSpotColor: false,
        lineWidth: 1.15
      });
    }

    //CounterUp Init
    counter();

    //Row 1
    sparklines();

  };

  return App;
})(App || {});



$(document).ready(function() {
    App.dashboard();
});