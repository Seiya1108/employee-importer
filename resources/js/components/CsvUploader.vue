<template>
  <div
    class="border-4 border-dashed border-gray-300 p-10 rounded-lg text-center transition-colors hover:border-blue-400 cursor-pointer"
    @dragover.prevent
    @drop.prevent="handleDrop"
    @click="$refs.fileInput.click()"
  >
    <p class="text-lg font-semibold mb-4 text-gray-700">
      📥 CSVファイルをここにドラッグ＆ドロップ<br />
      またはクリックしてファイルを選択してください
    </p>

    <!-- 非表示のファイル入力 -->
    <input
      type="file"
      ref="fileInput"
      accept=".csv"
      class="hidden"
      @change="handleFileChange"
    />

    <div v-if="uploading" class="mt-4 text-gray-600">アップロード中...</div>
    <div v-if="successMessage" class="mt-4 text-green-600">{{ successMessage }}</div>
    <div v-if="errorMessage" class="mt-4 text-red-600">{{ errorMessage }}</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      uploading: false,
      successMessage: '',
      errorMessage: '',
    };
  },
  methods: {
    handleDrop(event) {
      const file = event.dataTransfer.files[0];
      if (file) this.uploadFile(file);
    },
    handleFileChange(event) {
      const file = event.target.files[0];
      if (file) this.uploadFile(file);
    },
    async uploadFile(file) {
      this.uploading = true;
      this.successMessage = '';
      this.errorMessage = '';

      const formData = new FormData();
      formData.append('file', file);

      try {
        const response = await fetch('/api/employees/import', {
          method: 'POST',
          body: formData,
        });

        if (!response.ok) throw new Error('アップロードに失敗しました');

        const result = await response.json();
        this.successMessage = result.message || 'アップロード成功！';
      } catch (error) {
        this.errorMessage = error.message;
      } finally {
        this.uploading = false;
      }
    },
  },
};
</script>