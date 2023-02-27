import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';

const withIsLayoutConstrainedClassName = createHigherOrderComponent((BlockListBlock) => {
  return (props) => {
      const { attributes } = props;
      if (attributes.align && attributes.align === 'full') {
        props = { ...props, ...{ className: 'is-layout-constrained' } };
      }

      return <BlockListBlock { ...props } />;
  };
}, 'withIsLayoutConstrainedClassName');
addFilter('editor.BlockListBlock', __PREFIX__ + '/add-is-layout-constrained-to-alignfull', withIsLayoutConstrainedClassName);