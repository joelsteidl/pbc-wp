// External Dependencies
import React, { Component, Fragment } from 'react';

// Internal Dependencies
import './style.css';


class SeriesEngine extends Component {

  static slug = 'enmse_series_engine';

  render() {
    return (
      <Fragment>
        <div className="enmse-placeholder">
          <h1 className="enmse-heading">Your Series Engine Embed Will Show Up Here</h1>
          <p>
            Click the gear icon on this module to edit its settings. After you save your changes in the Visual Builder, you will see your Series Engine content here on your live site according to the settings you specified in the Series Engine Divi Module. Remember, Series Engine will look best in a wide, or full-width column.
          </p>
          <p>
            You can change styles for fonts and colors in Settings > Series Engine in the WordPress portal.
          </p>
        </div>
      </Fragment>
    );
  }
}

export default SeriesEngine;