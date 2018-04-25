import React from 'react';
import RichTextInput from 'aor-rich-text-input';
import { HydraAdmin } from '@api-platform/admin';
import parseHydraDocumentation from '@api-platform/api-doc-parser/lib/hydra/parseHydraDocumentation';

const myApiDocumentationParser = entrypoint => parseHydraDocumentation(entrypoint)
    .then( ({ api }) => {
        const decisions = api.resources.find(({ name }) => 'decisions' === name);
        const description = decisions.fields.find(f => 'description' === f.name);

        description.input = props => (
            <RichTextInput {...props} source="description" />
    );

        description.input.defaultProps = {
            addField: true,
            addLabel: true
        };

        return { api };
    })
;

export default (props) => <HydraAdmin apiDocumentationParser={myApiDocumentationParser} entrypoint="https://localhost:8443/"/>;
