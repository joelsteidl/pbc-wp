import React from "react";

class Swatches extends React.Component {
  constructor() {
      super();
    this.state = {
      searchSwatch: ""
    };
    this.currentBookMark = null;
  }

  _handleBlur(event) {
    setTimeout(
      function() {
        if (this.currentBookMark) {
          this.currentBookMark = null;
          this.props.resetState ? this.props.resetState() : null;
        }
      }.bind(this),
      0
    );
  }

  // Swatch Search
  searchSwatches(event) {
    this.setState({
      searchSwatch: event.target.value
    });
    this.props.useOverride ? this.props.useOverride(false) : null;
  }
  // Convert RGB Color To HEX Value
  rgbToHex(rgbColor) {
    if ("#" == rgbColor.charAt(0)) {
      return rgbColor;
    } else {
      var rgbSplit = rgbColor
        .replace("rgba", "")
        .replace("(", "")
        .replace(")", "")
        .split(",");
      return (
        this.convertComponent(rgbSplit[0]) +
        "" +
        this.convertComponent(rgbSplit[1]) +
        "" +
        this.convertComponent(rgbSplit[2])
      );
    }
  }
  // Get Swatches from Prop
  getSwatchInfo(searchKey) {
    var swatchFromHub = this.props.colorHub.hasOwnProperty("swatches")
        ? this.props.colorHub.swatches
        : "", //default set of swatches
      swatchArray = [];
    searchKey = searchKey.toLowerCase();
    for (var swatch in swatchFromHub) {
      var swatchBG = {
        background: this.computeGradientforSwatchAndPalette(
          swatchFromHub[swatch].color
        )
      };
      if (
        swatchFromHub[swatch].label.toLowerCase().startsWith(searchKey) ||
        (typeof swatchFromHub[swatch].color === "string" &&
          searchKey.startsWith("#") &&
          this.rgbToHex(swatchFromHub[swatch].color)
            .toLowerCase()
            .startsWith(searchKey))
      ) {
        swatchArray.push({
          key: swatch,
          label: swatchFromHub[swatch].label,
          color: swatchFromHub[swatch].color,
          style: swatchBG
        });
      }
    }
    return swatchArray;
  }

  // Compute Gradient Value from Color Hub Data
  computeGradientforSwatchAndPalette(colorHubData) {
    if (typeof colorHubData !== "object") {
      return colorHubData;
    } else {
      var colorValue = "",
        colorStops = Object.keys(colorHubData.colorPositions).length;

      if (colorStops == 1) {
        colorValue = colorHubData.colorPositions[0];
      } else {
        colorValue = "linear-gradient(";
        colorValue = colorValue + colorHubData.angle + "deg";
        for (var position in colorHubData.colorPositions) {
          colorValue =
            colorValue +
            "," +
            colorHubData.colorPositions[position] +
            " " +
            position +
            "%";
        }
        colorValue = colorValue + ")";
      }
      return colorValue;
    }
  }

  render() {
    return (
      <div className="be-swatch-wrap">
        <input
          type="text"
          className="swatch-search"
          name="Search Swatches"
          placeholder="Search"
          value={this.state.searchSwatch}
          onBlur={this._handleBlur}
          onChange={this.searchSwatches}
        />
        {this.getSwatchInfo(this.state.searchSwatch).map(function(item, index) {
          return (
            <div
              key={item.key}
              data-label={item.label}
              className={
                "single-swatch " +
                (this.props.selectedSwatch === item.key
                  ? "show-selection"
                  : "") +
                (!this.props.enableGradient && typeof item.color === "object"
                  ? "disbaled-swatch"
                  : "")
              }
              style={item.style}
              onClick={
                !this.props.enableGradient && typeof item.color === "object"
                  ? ""
                  : this.props.swatchClick.bind(this, item)
              }
            />
          );
        }, this)}
      </div>
    );
  }
}

module.exports = Swatches;
