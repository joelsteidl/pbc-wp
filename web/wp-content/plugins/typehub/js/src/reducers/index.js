import {combineReducers} from 'redux';
import initConfig from './initConfig';
import fontSchemes from './fontSchemes';
import tempWorks from './tempWorks';
import settings from './settings';
import custom from './custom';

const rootReducers = combineReducers({

    initConfig,
    fontSchemes,
    tempWorks,
    settings,
    custom
});

export default rootReducers;