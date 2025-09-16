import React from 'react';
import ReactDOM from 'react-dom';

export default function Example() { 
    return (
        <div>
            <h1>Hello, React!</h1>
            <p>This is a simple React component.</p>
        </div>
    );
}

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals

if (document.getElementById('example')) {
    ReactDOM.render(<Example />, document.getElementById('example'));
}
