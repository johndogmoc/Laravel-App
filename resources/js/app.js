/**
 * App entry: load dependencies, then render our Router into #root
 */
require('./bootstrap');

import React from 'react';
import ReactDOM from 'react-dom';
import Routers from './components/Routers';

const root = document.getElementById('root');
if (root) {
  ReactDOM.render(<Routers />, root);
}
