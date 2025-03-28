import EditorJS, { BlockToolConstructable, OutputData } from "@editorjs/editorjs";
import ImageTool from "@editorjs/image";
import Header from "@editorjs/header";
import Quote from '@editorjs/quote';
import Embed from '@editorjs/embed';
import Delimiter from '@editorjs/delimiter';
// import Warning from '@editorjs/warning';
import EditorjsList from '@editorjs/list';
import Paragraph from '@editorjs/paragraph';
import Raw from '@editorjs/raw';
import Checklist from '@editorjs/checklist';

const csrfToken = document?.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

interface Props {
  fieldName: string;
  appUrl: string;
  value: string | null;
}

export function editor(props: Props) {
  const { fieldName, appUrl, value } = props;
  const editor = new EditorJS({
    data: value ? JSON.parse(value) : {},
    holder: `editor_${fieldName}`,
    inlineToolbar: true,
    tools: {
      image: {
        class: ImageTool,
        config: {
          endpoints: {
            byFile: `${appUrl}/editorjs/uploadFile`,
            byUrl: `${appUrl}/editorjs/uploadUrl`,
          },
          additionalRequestHeaders: {
            "X-CSRF-TOKEN": csrfToken,
          },
        },
      },
      header: {
        class: Header as any,
        inlineToolbar: true,
      },
      quote: {
        class: Quote as any,
        inlineToolbar: true
      },
      embed: {
        class: Embed as any,
        inlineToolbar: true,
        config: {
          services: {
            youtube: true,
            twitch: true,
            soundcloud: true,
            vimeo: true,
            instagram: true,
            facebook: true,
            twitter: true,
            tiktok: true,
          },
        },
      },
      delimiter: Delimiter,
      list: {
        class: EditorjsList as any,
        inlineToolbar: true,
        config: {
          defaultStyle: 'unordered'
        },
      },
      // warning: Warning,
      paragraph: {
        class: Paragraph as any,
        inlineToolbar: true
      },
      raw: {
        class: Raw as any,
        inlineToolbar: true
      },
      // checklist: Checklist
    },
    onChange: (_api, _event) => {
      editor
        .save()
        .then((outputData) => {
          const input = document.getElementById(`input_${fieldName}`);
          if (input instanceof HTMLInputElement) {
            input.value = JSON.stringify(outputData);
          }
        })
        .catch((error) => {
          console.error("EditorJS::Saving failed: ", error);
        });
    },
  });

  return editor;
}

window.EditorJS = editor;
