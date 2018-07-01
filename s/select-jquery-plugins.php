<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>untitled</title>
    <meta name="description" content="">
    <meta name="author" content="electric_g">
    <link rel="stylesheet" href="">
	<style type="text/css">
    /* selectColored */
    select.colorize option {
    	color: #000000;
    }
    select.colorize option.def, select.colorize.empty {
    	color: #999999;
    }
    /* selectRemoveOption */
    select.remove option[disabled] {
        display: none;
    }
    	</style>
</head>
<body>
    <table>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th>Date Format</th>
        </tr>
        <tr>
            <td>
                <select class="s s0">
                    <option value="-1">Other</option>
                    <option value="0">aaaa</option>
                    <option value="1">bbbb</option>
                    <option value="2">cccc</option>
                    <option value="3">dddd</option>
                    <option value="4">eeee</option>
                    <option value="5" selected="selected">ffff</option>
                </select>
            </td>
            <td><input type="text" /></td>
            <td>
                <select class="s s1" name="s1[]">
                    <option value="-1">Select the column</option>
                    <option value="0">aaaa</option>
                    <option value="1">bbbb</option>
                    <option value="2" selected="selected">cccc</option>
                    <option value="3">dddd</option>
                    <option value="4">eeee</option>
                    <option value="5">ffff</option>
                </select>
            </td>
            <td>
                <input type="checkbox" />
                <select disabled="disabled">
                    <option value="-1">Select the format</option>
                    <option value="0">xxxx</option>
                    <option value="1">yyyy</option>
                </select>
            </td>
        </tr>
        <?php
        for ($i = 0; $i < 15; $i++) {
            ?>
            <tr>
                <td>
                    <select class="s s0">
                        <option value="-1">Other</option>
                        <option value="0">aaaa</option>
                        <option value="1">bbbb</option>
                        <option value="2">cccc</option>
                        <option value="3">dddd</option>
                        <option value="4">eeee</option>
                        <option value="5">ffff</option>
                    </select>
                </td>
                <td><input type="text" /></td>
                <td>
                    <select class="s s1" name="s1[]">
                        <option value="-1">Select the column</option>
                        <option value="0">aaaa</option>
                        <option value="1">bbbb</option>
                        <option value="2">cccc</option>
                        <option value="3">dddd</option>
                        <option value="4">eeee</option>
                        <option value="5">ffff</option>
                    </select>
                </td>
                <td>
                    <input type="checkbox" />
                    <select disabled="disabled">
                        <option value="-1">Select the format</option>
                        <option value="0">xxxx</option>
                        <option value="1">yyyy</option>
                    </select>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>

    <script src="../../lib/js/jquery-1.6.2.min.js"></script>
    <script>
(function($) {
	// Autocomplete from the select
	$.fn.autoSelect = function(options) {// plugin definition
		var defaults = {
			prex : 'listBean_field',
			subx : 'Col',
			prexTo : 'listBean_field',
			subxTo : 'Name',
			resetVal : -1
		};
		// extend default options with those provided
		var opts = $.extend(defaults, options);

		// implementation code
		return this.each(function() {
			var $wrapper = $(this),
				$colList = $wrapper.find('select[name^=' + opts.prex + '][name$=' + opts.subx + ']'),
				regex = new RegExp(opts.prex + '(\\d+)' + opts.subx);

			$colList.bind('change', function() {
				var $this = $(this),
					name = $this.attr('name'),
					val,
					n = name.match(regex);
				if ($this.val() != opts.resetVal) {
					val = $this.find(':selected').text();
				}
				else {
					val = '';
				}
				$wrapper.find('input[name=' + opts.prexTo + n[1] + opts.subxTo + ']').val(val);
			});
		});
	};// end plugin definition

	// Activate from the checkbox
	$.fn.selectActivateField = function(options) {// plugin definition
		var defaults = {
			prex : 'field',
			subx : 'DateInd',
			prexTo : 'listBean_field',
			subxTo : 'DataFormat'
		};
		// extend default options with those provided
		var opts = $.extend(defaults, options);

		// implementation code
		return this.each(function() {
			var $wrapper = $(this),
				$checkList = $wrapper.find('input[name^=' + opts.prex + '][name$=' + opts.subx + ']'),
				regex = new RegExp(opts.prex + '(\\d+)' + opts.subx);

			function check($what) {
				var name = $what.attr('name'),
					val,
					n = name.match(regex),
					$el = $wrapper.find(':input[name=' + opts.prexTo + n[1] + opts.subxTo + ']');
				if ($what.is(':checked')) {
					$el.removeAttr('disabled').removeClass('invisible');
				}
				else {
					$el.attr('disabled', 'disabled').addClass('invisible');
				}
			}

			$checkList.bind('change', function() {
				check($(this));
			});

			// initialize
			$checkList.each(function() {
				check($(this));
			});
		});
	};// end plugin definition


	// Color the empty select
	$.fn.selectColored = function(options) {
		var defaults = {
			def        : -1,
			classSel   : 'colorize',
			classEmpty : 'empty',
			classDef   : 'def'
		};
		// extend default options with those provided
		var opts = $.extend(defaults, options);

		// implementation code
		return this.each(function() {
			var $select = $(this);
			$select
				.addClass(opts.classSel)
				.find('option[value="' + opts.def + '"]')
				.addClass(opts.classDef);

			function color() {
				$select.toggleClass(opts.classEmpty, ($select.val() == opts.def));
			}

			$select.bind('change', function() {
				color();
			});

			// initialize
			color();
		});
	};// end plugin definition


	// Remove already choose options
	$.fn.selectRemoveOption = function(options) {
		var defaults = {
			def         : -1,
			classRemove : 'remove',
			tagRemove   : 'span'
		};
		// extend default options with those provided
		var opts = $.extend(defaults, options);

		var $select = $(this);
		// use the data method to store the previous value for each select box
		$select.data('valOld', '');

		// implementation code
		return this.each(function() {
			var $this = $(this),
				valNew,
				$justLeft, $toRemove;

			$this.addClass(opts.classRemove);

			function remove() {
				var $others = $select.not($this);
				valNew = $this.val();
				// enable the just left option
				$justLeft = $others.find(opts.tagRemove + '[value="' + $this.data('valOld') + '"]');
				$justLeft.replaceWith('<option value="' + $this.data('valOld') + '">' + $justLeft.html() + '</option>');
				// disable the selected option
				if (valNew != opts.def) {
					$toRemove = $others.find('option[value="' + valNew + '"]');
					$toRemove.replaceWith('<' + opts.tagRemove + ' value="' + valNew + '">' + $toRemove.html() + '</' + opts.tagRemove + '>');
				}
				// memorize the value for the next change
				$this.data('valOld', valNew);
			}

			// use the focus to store the previous value, since it's the only action certainly
			// called at least for the first time. for the subsequent times, if focus is not
			// called, the value is anyway stored in the object
			$this.bind('focus', function() {
				$this.data('valOld', $this.val());
			})
			.bind('change', function() {
				remove();
			});

			// initialize
			remove();
		});
	}; // end plugin definition

})(jQuery);
    </script>
    <script>
$(document).ready(function() {
    $('.s').selectColored();
});
    </script>
</body>
</html>