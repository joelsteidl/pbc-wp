import React from 'react';
import CSSTransition from 'react-transition-group/CSSTransition';


const Fade = (props) => (
  <CSSTransition
    {...props}
    timeout={600}
    classNames={'fade'}
  >
      {props.children}
  </CSSTransition>
);


  export default Fade;