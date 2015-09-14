/**
 * Created by robert on 14/09/2015.
 */
jQuery(document).ready(function ($) {

    // suppress the tooltip display for the links that have suppress-tooltip
    $suppressTooltip = $(".suppress-tooltip");

    $suppressTooltip.hover(function () {

        function tmpTitle($this) {
            // Store it in a temporary attribute
            $this.attr("tmp_title", title);

            // Set the title to nothing so we don't see the tooltips
            $this.attr("title", "");
        }

        $this = $(this);

        // Get the current title
        var title = $this.attr("title");

        if (title != "") {
            tmpTitle($this);
            tmpTitle($this.find('img'));
        }


    });

    // Fired when we leave the element
    $suppressTooltip.click(function () {

        // Retrieve the title from the temporary attribute
        var title = $(this).attr("tmp_title");
        if (title != "") {

            // Return the title to what it was
            $(this).attr("title", title);
        }


    });

});