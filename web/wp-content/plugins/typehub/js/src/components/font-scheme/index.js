import React from 'react';
import SchemeEdit from './scheme-edit';
import AvailableSchemes from './schemes-available';
import shortId from'shortid';

class FontScheme extends React.Component{

    constructor(){
        super();
        this.state = { showEditOption:false }
        this.editOptionViewUpdater = this.editOptionViewUpdater.bind(this);
    }

    editOptionViewUpdater(value){
        this.setState({showEditOption:value});
    }

    render(){
        return (
        <div>
            <AvailableSchemes editOptionState={this.state.showEditOption} addSchemeListener={this.editOptionViewUpdater} />

           { <SchemeEdit in={this.state.showEditOption} place='adder' schemeKey={shortId.generate()} addSchemeListener={this.editOptionViewUpdater} />}
        </div>
        )
    }

}
export default FontScheme;