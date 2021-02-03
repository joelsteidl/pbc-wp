import React from 'react';
import { connect } from 'react-redux';
import { Radio, Icon, message, Tabs } from 'antd';
import SchemesList from './scheme-list';
import deepEqual from 'deep-equal';
import acScheme from '../../../actions/acScheme';

const RadioButton = Radio.Button;
const RadioGroup = Radio.Group;
const TabPane = Tabs.TabPane;


class AvailableSchemes extends React.Component {

    constructor() {
        super();
        this.state = {
            clickedScheme: null
        }
        this.schemeClicked = this.schemeClicked.bind(this);
        this.hideSchemeEdit = this.hideSchemeEdit.bind(this);
        this.schemeDelete = this.schemeDelete.bind(this);
    }


    schemeClicked(scheme, e) {
        if (e.target.className.split(' ')[1] !== 'ant-switch') {
            if (this.state.clickedScheme) {
                this.setState({ clickedScheme: null })
                this.props.addSchemeListener(false);
            }
            else {
                this.setState({ clickedScheme: scheme });
                this.props.addSchemeListener(false);
            }

        }
    }

    schemeDelete(scheme, e) {
        this.setState({ clickedScheme: null });
        this.props.addSchemeListener(false);
        this.props.dispatch(acScheme.deleteScheme({ scheme: scheme }));
        message.info('Scheme Deleted!');

    }

    hideSchemeEdit() {
        this.setState({ clickedScheme: null });
    }


    render() {

        let activeItems = Object.keys(this.props.store.fontSchemes).filter((val) =>
            this.props.store.fontSchemes[val].active === true)

        let inActiveItems = Object.keys(this.props.store.fontSchemes).length - activeItems.length;

        return (
            <div className='dummyId' style={{ margin: '30px 40px 10px 40px' }} >
                <Tabs defaultActiveKey='1' tabBarGutter={0} >
                    <TabPane tab={activeItems.length ? `Active (${activeItems.length})` : 'Active'} key='1'>
                        <SchemesList
                            hideScheme={this.hideSchemeEdit}
                            clickedScheme={this.state.clickedScheme}
                            itemCheckListener={this.schemeClicked}
                            mode={true} />
                    { !this.state.clickedScheme &&
                        <div
                            style={{ paddingLeft: '40%', background: '#fff', cursor: 'pointer' }}
                            onClick={this.props.addSchemeListener.bind(this, !this.props.editOptionState)}
                        >
                            <a style={{
                                background: '#fff',
                                color: '#108ee9',
                                height: '30px',
                                width: '100%',
                                display: 'inline-block',
                                padding: '10px 0px 30px 50px'
                            }}
                            >
                                {this.props.editOptionState ?
                                    <span style={{ color: 'red' }} > <Icon style={{ fontWeight: 900 }} type="close" /> Cancel </span> :
                                    <span><Icon style={{ fontWeight: 900 }} type="plus" /> Add New Font</span>}</a></div>}
                    </TabPane>
                    <TabPane tab={inActiveItems ? `Inactive(${inActiveItems})` : 'Inactive'} key='2'>
                        <SchemesList
                            hideScheme={this.hideSchemeEdit}
                            clickedScheme={this.state.clickedScheme}
                            schemeDeleteListener={this.schemeDelete}
                            itemCheckListener={this.schemeClicked}
                            mode={false} />
                    </TabPane>
                </Tabs>

            </div>
        )
    }


}
function mapStateToProps(store, ownProps) {
    return {
        store
    }
}
export default connect(mapStateToProps)(AvailableSchemes);