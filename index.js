panel.plugin('bvdputte/kirby-menus', {
    fields: {
        linkobject: {
            extends: 'k-object-field',
            // template: '<p>test</p>'
        }
    },
    components: {
      'k-linkobject-field-preview': {
        props: {
          value: String,
          column: Object,
          field: Object,
        },
        computed: {
          previewValue() {
            // console.log(this.$helper.link.detect(this.value.link));
            // console.log(this.$helper.link.getPageUUID(this.value.link));
            // console.log(this.value.link);
            if ( this.value.haslinktext ) {
                return this.value.linktext
            } else {
                return this.value.link
            }
          }
        },
        template: `<p class="k-text-field-preview" style="display: flex; gap: 0.25rem;">
                <span><k-icon type="url"></span>
                <span>{{ previewValue }}</span>
            </p>`
      }
    }
  });
