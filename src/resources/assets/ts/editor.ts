import EditorJS, { OutputData } from "@editorjs/editorjs";
import ImageTool from "@editorjs/image";
import Header from "@editorjs/header";
import Quote from '@editorjs/quote';

const csrfToken = document?.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

interface Props {
  fieldName: string;
  appUrl: string;
  value: string;
}

export function editor(props: Props) {
  const { fieldName, appUrl, value } = props;
  console.log('value:: ', props);
  const editor = new EditorJS({
    data: JSON.parse(value),
    holder: `editor_${fieldName}`,
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
      header: Header,
      quote: Quote
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
