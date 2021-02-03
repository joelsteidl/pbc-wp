import React from "react";

class Palettes extends React.Component {
  constructor() {
    super();
    this.state = { selectedPalette: "" };
  }

  // Get the current Color Hub Palette
  getCurrentColorHubPalette(palettes) {
    var currentPaletteID = palettes.currentPalette;
    return palettes.allPalettes[currentPaletteID];
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
    var paletteFromHub = this.props.colorHub.hasOwnProperty("palettes")
        ? this.props.colorHub.palettes
        : "", //default set of palettes
      currentPaletteArray = this.getCurrentColorHubPalette(paletteFromHub);
    return (
      <div className="be-palette-wrap">
        {currentPaletteArray.map(function(item, index) {
          return (
            <div
              key={index}
              className={
                "single-palette " +
                (parseInt(this.props.selectedPalette) === index
                  ? "show-selection"
                  : "") +
                (!this.props.enableGradient && typeof item.color === "object"
                  ? "disbaled-swatch"
                  : "")
              }
              style={{
                background: this.computeGradientforSwatchAndPalette(item)
              }}
              onClick={
                !this.props.enableGradient && typeof item.color === "object"
                  ? ""
                  : this.props.paletteClick.bind(this, index, item)
              }
            />
          );
        }, this)}
      </div>
    );
  }
}

module.exports = Palettes;
