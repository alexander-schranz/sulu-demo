import React from 'react';
import { observer } from 'mobx-react';

@observer
class HeadlessTemplatePage extends React.Component {
    render() {
        const serializedData = JSON.stringify(this.props.data, null, 2);

        return (<pre>{ serializedData }</pre>);
    }
}

export default HeadlessTemplatePage;
